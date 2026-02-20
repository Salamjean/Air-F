<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipement;
use App\Models\EquipementCategory;
use App\Models\Intervention;
use App\Models\StockMovement;
use App\Models\Site;
use App\Exports\EquipementExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EquipementController extends Controller
{
    public function index(Request $request)
    {
        $categories = EquipementCategory::all();
        $sites = Site::all();
        $categoryId = $request->get('category_id');
        $siteId = $request->get('site_id');
        $lowStock = $request->has('low_stock');

        $query = Equipement::with(['category', 'creator', 'sites']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($siteId) {
            $query->whereHas('sites', function ($q) use ($siteId) {
                $q->where('site_id', $siteId);
            });
        }

        if ($lowStock) {
            $query->where('stock_quantity', '<=', 5);
        }

        $equipements = $query->latest()->get();

        return view('admin.equipements.index', compact('equipements', 'categories', 'sites', 'categoryId', 'siteId', 'lowStock'));
    }

    public function create()
    {
        $categories = EquipementCategory::all();
        $sites = Site::all();
        return view('admin.equipements.create', compact('categories', 'sites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'longueur' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'numero_bien' => 'nullable|string|max:255',
            'category_id' => 'required|exists:equipement_categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock_quantity' => 'required|integer|min:0',
            'stock_min_alert' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'site_id' => 'required|exists:sites,id',
        ]);

        $data = $request->all();
        $data['added_by'] = Auth::guard('user')->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('equipements', 'public');
        }

        $equipement = Equipement::create($data);

        // Associate with site
        $equipement->sites()->attach($request->site_id, [
            'quantity' => $request->stock_quantity,
            'alert_threshold' => $request->stock_min_alert,
        ]);

        return redirect()->route('admin.equipements.index')->with('success', 'Équipement ajouté avec succès.');
    }

    public function edit(Equipement $equipement)
    {
        $categories = EquipementCategory::all();
        $sites = Site::all();
        $currentSiteId = $equipement->sites()->first()?->id;
        return view('admin.equipements.edit', compact('equipement', 'categories', 'sites', 'currentSiteId'));
    }

    public function update(Request $request, Equipement $equipement)
    {
        $oldStock = $equipement->stock_quantity;

        $request->validate([
            'name' => 'required|string|max:255',
            'longueur' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'numero_bien' => 'nullable|string|max:255',
            'category_id' => 'required|exists:equipement_categories,id',
            'description' => 'nullable|string',
            'stock_quantity' => 'required|integer|min:0',
            'stock_min_alert' => 'required|integer|min:0',
            'unit' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_id' => 'required|exists:sites,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($equipement->image) {
                Storage::disk('public')->delete($equipement->image);
            }
            $data['image'] = $request->file('image')->store('equipements', 'public');
        }

        $equipement->update($data);

        // Log adjustment if stock was changed manually in edit
        if ($oldStock != $equipement->stock_quantity) {
            StockMovement::create([
                'equipement_id' => $equipement->id,
                'user_id' => auth()->id(),
                'type' => 'adjustment',
                'quantity' => $equipement->stock_quantity - $oldStock,
                'description' => 'Ajustement manuel du stock (Modification)',
            ]);
        }

        // Update site association
        $equipement->sites()->sync([
            $request->site_id => [
                'quantity' => $equipement->stock_quantity,
                'alert_threshold' => $equipement->stock_min_alert,
            ]
        ]);

        return redirect()->route('admin.equipements.index')->with('success', 'Équipement mis à jour avec succès.');
    }

    public function destroy(Equipement $equipement)
    {
        if ($equipement->image) {
            Storage::disk('public')->delete($equipement->image);
        }
        $equipement->delete();
        return redirect()->route('admin.equipements.index')->with('success', 'Équipement supprimé avec succès.');
    }

    public function recharge(Request $request, Equipement $equipement)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $equipement->increment('stock_quantity', $request->quantity);

        StockMovement::create([
            'equipement_id' => $equipement->id,
            'user_id' => auth()->id(),
            'type' => 'recharge',
            'quantity' => $request->quantity,
            'description' => $request->description ?? 'Rechargement de stock',
        ]);

        return back()->with('success', "Le stock de {$equipement->name} a été rechargé de {$request->quantity} {$equipement->unit}.");
    }

    public function history(Request $request)
    {
        $search = $request->get('search');

        $usageHistory = StockMovement::with(['equipement', 'user', 'intervention.prestataire', 'intervention.personnel'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('equipement', function ($eq) use ($search) {
                        $eq->where('name', 'like', "%{$search}%");
                    })
                        ->orWhereHas('intervention', function ($iq) use ($search) {
                            $iq->where('code', 'like', "%{$search}%")
                                ->orWhereHas('prestataire', function ($pq) use ($search) {
                                    $pq->where('name', 'like', "%{$search}%")
                                        ->orWhere('prenom', 'like', "%{$search}%");
                                })
                                ->orWhereHas('personnel', function ($sq) use ($search) {
                                    $sq->where('name', 'like', "%{$search}%")
                                        ->orWhere('prenom', 'like', "%{$search}%");
                                });
                        });
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.equipements.history', compact('usageHistory', 'search'));
    }

    public function export(Request $request)
    {
        $categoryId = $request->get('category_id');
        $siteId = $request->get('site_id');
        $lowStock = $request->has('low_stock');

        $siteName = null;
        if ($siteId) {
            $site = Site::find($siteId);
            $siteName = $site ? $site->name : null;
        }

        $fileName = 'consommables-' . now()->format('d-m-Y-H-i') . '.xlsx';

        return Excel::download(
            new EquipementExport($categoryId, $siteId, $lowStock, $siteName),
            $fileName
        );
    }
}
