<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResponsableIntervention extends Controller
{
    public function envoyees(Request $request)
    {
        $query = Intervention::where('statut', 'envoyer')->with(['personnels', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('responsable.interventions.envoyees', compact('interventions'));
    }

    public function confirmer(Request $request)
    {
        $query = Intervention::where('statut', 'facture')
            ->with(['personnels', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('responsable.interventions.confirmer', compact('interventions'));
    }

    public function devis(Request $request)
    {
        $query = Intervention::where('statut', 'devis')
            ->with(['personnels', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('responsable.interventions.devis', compact('interventions'));
    }

    public function traitees(Request $request)
    {
        $query = Intervention::where('statut', 'traiter')
            ->with(['personnels', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('responsable.interventions.traitees', compact('interventions'));
    }

    public function accordees(Request $request)
    {
        $query = Intervention::whereIn('statut', ['accord'])
            ->with(['personnels', 'prestataire', 'responsable']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        $financiers = User::where('role', 'finance')->get();
        return view('responsable.interventions.accordees', compact('interventions', 'financiers'));
    }

    public function assignFinance(Request $request, Intervention $intervention)
    {
        $request->validate([
            'financier_id' => 'required|exists:users,id',
        ]);

        try {
            $intervention->financier_id = $request->financier_id;
            $intervention->statut = 'finance';
            $intervention->date_soumission_finance = now();
            $intervention->save();

            Log::info('Intervention assignée au financier ID: ' . $request->financier_id . ' - Ref: ' . $intervention->reference);
            return back()->with('success', 'Intervention envoyée à la finance avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'assignation à la finance : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function confirmAction(Intervention $intervention)
    {
        try {
            $intervention->statut = 'facture';
            $intervention->responsable_id = auth('user')->id();
            $intervention->save();

            Log::info('Intervention confirmée par Responsable ID: ' . auth('user')->id() . ' - Ref: ' . $intervention->reference);

            return redirect()->route('responsable.interventions.envoyees')->with('success', 'Intervention confirmée avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la confirmation de l\'intervention : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la confirmation.')->withInput();
        }
    }

    public function historique(Request $request)
    {
        $query = Intervention::where('statut', 'payer')
            ->with(['personnels', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('responsable.interventions.historique', compact('interventions'));
    }

    public function details(Intervention $intervention)
    {
        $intervention->load(['personnels', 'prestataire', 'site', 'forfait', 'forfaitTasks', 'equipements', 'documents']);
        return view('responsable.interventions.details', compact('intervention'));
    }
}
