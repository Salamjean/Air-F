<?php

namespace App\Http\Controllers\Financier;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FinancierInterventionController extends Controller
{
    /**
     * Display a listing of interventions to be received.
     */
    public function index(Request $request)
    {
        $query = Intervention::where('statut', 'finance')
            ->where('financier_id', Auth::guard('user')->id())
            ->with(['personnels', 'prestataire']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('financier.interventions.index', compact('interventions'));
    }

    /**
     * Mark the specified intervention as received.
     */
    public function receptionner(Intervention $intervention)
    {
        if ($intervention->financier_id !== Auth::guard('user')->id() || $intervention->statut !== 'finance') {
            return back()->with('error', 'Action non autorisée ou déjà réceptionnée.');
        }

        try {
            $intervention->statut = 'receptionne';
            $intervention->date_reception_finance = now();
            $intervention->save();

            Log::info('Intervention réceptionnée par financier : ' . $intervention->reference);

            return redirect()->route('financier.interventions.paiement_detail', $intervention->id)->with('success', 'Intervention réceptionnée avec succès. Vous pouvez maintenant fixer le délai de paiement.');
        } catch (Exception $e) {
            Log::error('Erreur réception financier: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la réception.');
        }
    }

    /**
     * List interventions waiting for a payment delay to be set.
     */
    public function attenteDelai(Request $request)
    {
        $query = Intervention::where('statut', 'receptionne')
            ->where('financier_id', Auth::guard('user')->id())
            ->with(['personnels', 'prestataire']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('financier.interventions.attente_delai', compact('interventions'));
    }

    /**
     * Set the payment delay.
     */
    public function fixerDelai(Request $request, Intervention $intervention)
    {
        if ($intervention->financier_id !== Auth::guard('user')->id() || $intervention->statut !== 'receptionne') {
            return back()->with('error', 'Action non autorisée.');
        }

        $request->validate([
            'delai_paiement' => 'required|in:30,45,60,95,120',
        ]);

        try {
            $intervention->statut = 'attente_paiement';
            $intervention->delai_paiement = $request->delai_paiement;

            // Calcul de la date de paiement prévue
            $dateSoumission = $intervention->date_soumission_finance ?? now();
            $intervention->date_paiement_prevue = \Carbon\Carbon::parse($dateSoumission)->addDays((int) $request->delai_paiement);

            $intervention->save();

            Log::info('Délai de paiement fixé par financier : ' . $intervention->reference . ' | Délai: ' . $request->delai_paiement . ' jours');

            return redirect()->route('financier.interventions.paiement_detail', $intervention->id)->with('success', 'Délai fixé avec succès. Date prévue : ' . $intervention->date_paiement_prevue->format('d/m/Y'));
        } catch (Exception $e) {
            Log::error('Erreur fixation délai financier: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la fixation du délai.');
        }
    }

    /**
     * List interventions waiting for final payment.
     */
    public function attenteReglement(Request $request)
    {
        $query = Intervention::where('statut', 'attente_paiement')
            ->where('financier_id', Auth::guard('user')->id())
            ->with(['personnels', 'prestataire']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('financier.interventions.attente_reglement', compact('interventions'));
    }

    /**
     * Display a detail page for payment validation.
     */
    public function paiementDetail(Intervention $intervention)
    {
        if ($intervention->financier_id !== Auth::guard('user')->id()) {
            return back()->with('error', 'Action non autorisée.');
        }

        $intervention->load(['personnels', 'prestataire']);

        return view('financier.interventions.paiement_detail', compact('intervention'));
    }

    /**
     * Display a listing of paid interventions.
     */
    public function historique(Request $request)
    {
        $query = Intervention::where('statut', 'payer')
            ->where('financier_id', Auth::guard('user')->id())
            ->with(['personnels', 'prestataire']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        return view('financier.interventions.historique', compact('interventions'));
    }

    /**
     * Mark the specified intervention as paid.
     */
    public function payer(Request $request, Intervention $intervention)
    {
        if ($intervention->financier_id !== Auth::guard('user')->id() || $intervention->statut !== 'attente_paiement') {
            return back()->with('error', 'Action non autorisée.');
        }

        try {
            $intervention->statut = 'payer';
            $intervention->date_paiement_effectif = now();
            $intervention->save();

            Log::info('Intervention marquée comme payée par financier : ' . $intervention->reference);

            return redirect()->route('financier.interventions.historique')->with('success', 'Paiement marqué comme effectué avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur paiement final financier: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la validation finale.');
        }
    }
}
