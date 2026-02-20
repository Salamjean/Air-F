<?php

namespace App\Http\Controllers\Prestataire;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrestataireIntervention extends Controller
{
    public function index()
    {
        $interventions = Intervention::where('prestataire_id', auth('user')->id())
            ->with(['personnels', 'prestataire', 'site'])
            ->latest()
            ->get();

        return view('prestataire.interventions.index', compact('interventions'));
    }

    public function validateIntervention(Request $request, Intervention $intervention)
    {
        // Ensure the intervention belongs to the authenticated prestataire
        if ($intervention->prestataire_id !== auth('user')->id()) {
            return back()->with('error', 'Action non autorisée.');
        }

        $rules = [
            'personnel_ids' => 'required|array',
            'personnel_ids.*' => 'exists:users,id',
            'responsible_id' => 'required|exists:users,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ];

        // Ensure responsible_id is in personnel_ids
        if (!in_array($request->responsible_id, $request->personnel_ids)) {
            return back()->with('error', 'Le responsable doit faire partie du personnel assigné.');
        }

        $request->validate($rules);

        try {
            // $intervention->personnel_id = $request->personnel_id; // Deprecated

            // Map personnel_ids to include pivot data
            $syncData = [];
            foreach ($request->personnel_ids as $id) {
                $syncData[$id] = ['is_responsible' => ($id == $request->responsible_id)];
            }

            $intervention->personnels()->sync($syncData);

            $intervention->date_debut = $request->date_debut;
            $intervention->date_fin = $request->date_fin;

            $intervention->statut = 'confirmer'; // Ou 'traiter' selon le workflow exact
            $intervention->save();

            Log::info('Intervention validée par prestataire : ' . $intervention->reference . ' | Personnel assigné count: ' . count($request->personnel_ids));

            return back()->with('success', 'Intervention validée avec succès.');

        } catch (Exception $e) {
            Log::error('Erreur validation prestataire: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function refuseIntervention(Request $request, Intervention $intervention)
    {
        if ($intervention->prestataire_id !== auth('user')->id()) {
            return back()->with('error', 'Action non autorisée.');
        }

        $request->validate([
            'motif_refus' => 'required|string|min:5',
        ]);

        try {
            $intervention->statut = 'rejeter';
            $intervention->motif_refus = $request->motif_refus;
            $intervention->save();

            Log::info('Intervention refusée par prestataire : ' . $intervention->reference . ' | Motif: ' . $request->motif_refus);

            return back()->with('success', 'Intervention refusée.');
        } catch (Exception $e) {
            Log::error('Erreur refus prestataire: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function enAttente(Request $request)
    {
        $query = Intervention::where('prestataire_id', auth('user')->id())
            ->where('statut', 'en_attente')->with(['personnels', 'prestataire', 'site']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        $personnels = \App\Models\User::where('prestataire_id', auth('user')->id())
            ->where('role', 'personnel')
            ->get();

        return view('prestataire.interventions.en_attente', compact('interventions', 'personnels'));
    }

    public function valider(Request $request)
    {
        $query = Intervention::where('prestataire_id', auth('user')->id())
            ->where('statut', 'confirmer')->with(['personnels', 'prestataire', 'site']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('prestataire.interventions.valider', compact('interventions'));
    }

    public function facturees(Request $request)
    {
        $query = Intervention::where('prestataire_id', auth('user')->id())
            ->where('statut', 'facture')->with(['personnels', 'prestataire', 'site']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('prestataire.interventions.facturees', compact('interventions'));
    }

    public function accordees(Request $request)
    {
        $query = Intervention::where('prestataire_id', auth('user')->id())
            ->where('statut', 'accord')->with(['personnels', 'prestataire', 'site']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('prestataire.interventions.accordees', compact('interventions'));
    }

    public function finance(Request $request)
    {
        $query = Intervention::where('prestataire_id', auth('user')->id())
            ->where('statut', 'finance')->with(['personnels', 'prestataire', 'site']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('prestataire.interventions.finance', compact('interventions'));
    }

    public function rejeter(Request $request)
    {
        $query = Intervention::where('prestataire_id', auth('user')->id())
            ->where('statut', 'rejeter')->with(['personnels', 'prestataire', 'site']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('prestataire.interventions.rejeter', compact('interventions'));
    }

    public function details(Intervention $intervention)
    {
        if ($intervention->prestataire_id !== auth('user')->id()) {
            return back()->with('error', 'Action non autorisée.');
        }

        $intervention->load(['personnels', 'prestataire', 'site']);
        return view('prestataire.interventions.details', compact('intervention'));
    }
    public function devisAttente(Request $request)
    {
        $query = Intervention::with('equipements')->where('prestataire_id', auth('user')->id())
            ->where('statut', 'traiter')->with(['personnels', 'prestataire', 'site']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('prestataire.interventions.devis.attente', compact('interventions'));
    }

    public function devisHistorique(Request $request)
    {
        // On récupère toutes les interventions où un devis a été soumis (montant_estimatif > 0 ou devis_path non nul)
        $query = Intervention::where('prestataire_id', auth('user')->id())
            ->where(function ($q) {
                $q->where('montant_estimatif', '>', 0)
                    ->orWhereNotNull('devis_path');
            })
            ->with(['personnels', 'prestataire', 'site']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('prestataire.interventions.devis.historique', compact('interventions'));
    }

    public function soumettreDevis(Request $request, Intervention $intervention)
    {
        if ($intervention->prestataire_id !== auth('user')->id()) {
            return response()->json(['error' => 'Action non autorisée'], 403);
        }

        $request->validate([
            'montant' => 'required|numeric',
            'devis_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Max 10MB
        ]);

        try {
            if ($request->hasFile('devis_file')) {
                $path = $request->file('devis_file')->store('devis', 'public');
                $intervention->devis_path = $path;
            }

            $intervention->montant_estimatif = $request->montant;
            $intervention->montant = $request->montant; // Par défaut, le montant final est celui du devis
            $intervention->statut = 'devis';
            $intervention->save();

            Log::info('Devis soumis par prestataire : ' . $intervention->reference . ' | Montant: ' . $request->montant);

            return response()->json(['success' => 'Devis soumis avec succès']);
        } catch (Exception $e) {
            Log::error('Erreur soumission devis: ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de la soumission.'], 500);
        }
    }

    public function rejeterRapport(Intervention $intervention)
    {
        if ($intervention->prestataire_id !== auth('user')->id()) {
            return back()->with('error', 'Action non autorisée.');
        }

        try {
            $intervention->statut = 'traiter_incorrect';
            $intervention->save();

            Log::info('Rapport rejeté par prestataire : ' . $intervention->reference);

            return back()->with('success', 'Le rapport a été signalé comme incorrect. Le personnel devra le corriger.');
        } catch (Exception $e) {
            Log::error('Erreur rejet rapport prestataire: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }
    public function soumettreFactureDefinitive(Request $request, Intervention $intervention)
    {
        if ($intervention->prestataire_id !== auth('user')->id()) {
            return response()->json(['error' => 'Action non autorisée'], 403);
        }

        $request->validate([
            'montant' => 'required|numeric',
            'facture_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Max 10MB
        ]);

        try {
            if ($request->hasFile('facture_file')) {
                $path = $request->file('facture_file')->store('factures', 'public');
                $intervention->facture_path = $path;
            }

            $intervention->montant = $request->montant;
            $intervention->statut = 'accord';
            $intervention->save();

            Log::info('Facture finale soumise par prestataire : ' . $intervention->reference . ' | Montant: ' . $request->montant);

            return response()->json(['success' => 'Facture soumise avec succès. L\'intervention est maintenant marquée comme accordée.']);
        } catch (Exception $e) {
            Log::error('Erreur soumission facture finale: ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de la soumission.'], 500);
        }
    }

    public function historique(Request $request)
    {
        $query = Intervention::where('prestataire_id', auth('user')->id())
            ->where('statut', 'payer')->with(['personnels', 'site']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('prestataire.interventions.historique', compact('interventions'));
    }
}
