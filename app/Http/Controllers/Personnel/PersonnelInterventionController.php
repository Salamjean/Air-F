<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Equipement;
use App\Models\StockMovement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PersonnelInterventionController extends Controller
{
    public function index(Request $request)
    {
        $query = Intervention::whereHas('personnels', function ($q) {
            $q->where('users.id', auth('user')->id());
        })->with(['personnels', 'site'])->whereIn('statut', ['confirmer', 'traiter_incorrect']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('personnel.interventions.index', compact('interventions'));
    }

    public function traitees(Request $request)
    {
        $query = Intervention::whereHas('personnels', function ($q) {
            $q->where('users.id', Auth::guard('user')->id());
        })->with(['personnels', 'site'])->whereIn('statut', ['traiter', 'devis', 'accord', 'finance', 'payer']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('personnel.interventions.historique', compact('interventions'));
    }

    public function show(Intervention $intervention)
    {
        if (!$intervention->personnels->contains(auth('user')->id())) {
            return back()->with('error', 'Action non autorisée.');
        }

        $intervention->load(['equipements', 'prestataire', 'site']);

        return view('personnel.interventions.details', compact('intervention'));
    }

    public function edit(Intervention $intervention)
    {
        if (!$intervention->personnels->contains(auth('user')->id())) {
            return back()->with('error', 'Action non autorisée.');
        }

        $isResponsible = $intervention->personnels()
            ->where('users.id', auth('user')->id())
            ->wherePivot('is_responsible', true)
            ->exists();

        if (!$isResponsible) {
            return back()->with('error', 'Seul le chef d\'équipe désigné peut soumettre le rapport.');
        }

        $equipements = Equipement::whereHas('sites', function ($q) use ($intervention) {
            $q->where('sites.id', $intervention->site_id)
                ->where('equipement_site.quantity', '>', 0);
        })->get();

        return view('personnel.interventions.edit', compact('intervention', 'equipements'));
    }

    public function update(Request $request, Intervention $intervention)
    {
        if (!$intervention->personnels->contains(auth('user')->id())) {
            return back()->with('error', 'Action non autorisée.');
        }

        $isResponsible = $intervention->personnels()
            ->where('users.id', auth('user')->id())
            ->wherePivot('is_responsible', true)
            ->exists();

        if (!$isResponsible) {
            return back()->with('error', 'Seul le chef d\'équipe désigné peut soumettre le rapport.');
        }

        $request->validate([
            'date_debut_reelle' => 'required|date',
            'date_fin_reelle' => 'required|date|after_or_equal:date_debut_reelle',
            'rapport_commentaire' => 'nullable|string',
            'rapport_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'equipements' => 'nullable|array',
            'equipements.*.id' => 'required|exists:equipements,id',
            'equipements.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('rapport_file')) {
                $path = $request->file('rapport_file')->store('rapports', 'public');
                $intervention->rapport_path = $path;
            }

            $intervention->date_debut_reelle = $request->date_debut_reelle;
            $intervention->date_fin_reelle = $request->date_fin_reelle;
            $intervention->rapport_commentaire = $request->rapport_commentaire;

            // Handle equipment usage (Consommables)
            if ($request->has('equipements')) {
                foreach ($request->equipements as $item) {
                    $equipement = Equipement::find($item['id']);
                    $siteId = $intervention->site_id;

                    // Check stock on the specific site
                    $siteStock = DB::table('equipement_site')
                        ->where('equipement_id', $equipement->id)
                        ->where('site_id', $siteId)
                        ->first();

                    if (!$siteStock || $siteStock->quantity < $item['quantity']) {
                        throw new Exception("Stock insuffisant sur ce site pour : " . $equipement->name);
                    }

                    $intervention->equipements()->attach($item['id'], ['quantity' => $item['quantity']]);

                    // Deduct from site stock
                    DB::table('equipement_site')
                        ->where('equipement_id', $equipement->id)
                        ->where('site_id', $siteId)
                        ->decrement('quantity', $item['quantity']);

                    // Deduct from global stock
                    $equipement->decrement('stock_quantity', $item['quantity']);

                    // Log stock movement for usage
                    StockMovement::create([
                        'equipement_id' => $equipement->id,
                        'user_id' => auth()->id(),
                        'intervention_id' => $intervention->id,
                        'type' => 'usage',
                        'quantity' => -$item['quantity'],
                        'description' => "Utilisation sur site {$intervention->site->name} ({$intervention->code})",
                    ]);
                }
            }

            // Mettre à jour le statut seulement si tout s'est bien passé (y compris les stocks)
            $intervention->statut = 'traiter';
            $intervention->save();

            DB::commit();
            Log::info('Intervention traitée par personnel : ' . $intervention->reference);

            return redirect()->route('personnel.interventions.index')->with('success', 'Rapport soumis et intervention traitée avec succès.');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erreur traitement personnel: ' . $e->getMessage());
            return back()->with('error', 'Erreur : ' . $e->getMessage())->withInput();
        }
    }
}
