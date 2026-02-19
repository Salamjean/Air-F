<?php

namespace App\Http\Controllers;

use App\Models\Forfait;
use App\Models\ForfaitTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ForfaitController extends Controller
{
    public function index()
    {
        $forfaits = Forfait::withCount('tasks')->get();
        return view('admin.forfaits.index', compact('forfaits'));
    }

    public function create()
    {
        return view('admin.forfaits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'tasks' => 'nullable|array',
            'tasks.*' => 'nullable|string',
        ]);

        try {
            $forfait = Forfait::create([
                'name' => $request->name,
                'label' => $request->label,
                'price' => $request->price,
            ]);

            if ($request->has('tasks')) {
                foreach ($request->tasks as $taskDescription) {
                    if (!empty($taskDescription)) {
                        $forfait->tasks()->create(['description' => $taskDescription]);
                    }
                }
            }

            return redirect()->route('admin.forfaits.index')->with('success', 'Forfait créé avec succès');
        } catch (Exception $e) {
            Log::error('Erreur lors de la création du forfait : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la création du forfait.')->withInput();
        }
    }

    public function edit(Forfait $forfait)
    {
        $forfait->load('tasks');
        return view('admin.forfaits.edit', compact('forfait'));
    }

    public function update(Request $request, Forfait $forfait)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'tasks' => 'nullable|array',
            'tasks.*' => 'nullable|string',
        ]);

        try {
            $forfait->update([
                'name' => $request->name,
                'label' => $request->label,
                'price' => $request->price,
            ]);

            // Simple task sync: delete old and create new
            // In a more complex scenario, we might want to update existing ones.
            $forfait->tasks()->delete();

            if ($request->has('tasks')) {
                foreach ($request->tasks as $taskDescription) {
                    if (!empty($taskDescription)) {
                        $forfait->tasks()->create(['description' => $taskDescription]);
                    }
                }
            }

            return redirect()->route('admin.forfaits.index')->with('success', 'Forfait mis à jour avec succès');
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour du forfait : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour du forfait.')->withInput();
        }
    }

    public function destroy(Forfait $forfait)
    {
        try {
            $forfait->delete();
            return redirect()->route('admin.forfaits.index')->with('success', 'Forfait supprimé avec succès');
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression du forfait : ' . $e->getMessage());
            return redirect()->route('admin.forfaits.index')->with('error', 'Impossible de supprimer ce forfait car il est peut-être lié à des interventions.');
        }
    }
}
