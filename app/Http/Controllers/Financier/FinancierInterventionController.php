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
     * Display a listing of interventions to be paid.
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
     * Display a detail page for payment validation.
     */
    public function paiementDetail(Intervention $intervention)
    {
        if ($intervention->financier_id !== Auth::guard('user')->id() || $intervention->statut !== 'finance') {
            return back()->with('error', 'Action non autorisée ou intervention non éligible au paiement.');
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
        if ($intervention->financier_id !== Auth::guard('user')->id()) {
            return back()->with('error', 'Action non autorisée.');
        }

        $request->validate([
            'delai_paiement' => 'required|in:30,45,95,120',
        ]);

        try {
            $intervention->statut = 'payer';
            $intervention->delai_paiement = $request->delai_paiement;

            // Calcul de la date de paiement prévue
            $dateSoumission = $intervention->date_soumission_finance ?? now();
            $intervention->date_paiement_prevue = \Carbon\Carbon::parse($dateSoumission)->addDays((int) $request->delai_paiement);

            $intervention->save();

            Log::info('Intervention payée par financier : ' . $intervention->reference . ' (ID: ' . Auth::guard('user')->id() . ') | Délai: ' . $request->delai_paiement . ' jours');

            return redirect()->route('financier.interventions.index')->with('success', 'Paiement validé avec succès. Date prévue : ' . $intervention->date_paiement_prevue->format('d/m/Y'));
        } catch (Exception $e) {
            Log::error('Erreur validation paiement financier: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la validation du paiement.');
        }
    }
}
