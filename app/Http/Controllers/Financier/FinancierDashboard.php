<?php

namespace App\Http\Controllers\Financier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancierDashboard extends Controller
{
    public function dashboard()
    {
        // Statistiques
        $interventionsToPay = \App\Models\Intervention::where('statut', 'finance')->count();
        $interventionsPaid = \App\Models\Intervention::where('statut', 'payer')->count();
        $totalPaidAmount = \App\Models\Intervention::where('statut', 'payer')->sum('montant');

        // Listes récentes
        $recentToPay = \App\Models\Intervention::where('statut', 'finance')
            ->with(['site'])
            ->latest()
            ->take(5)
            ->get();

        $recentPaid = \App\Models\Intervention::where('statut', 'payer')
            ->with(['site'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('financier.dashboard', compact(
            'interventionsToPay',
            'interventionsPaid',
            'totalPaidAmount',
            'recentToPay',
            'recentPaid'
        ));
    }

    public function logout()
    {
        auth('user')->logout();
        return redirect()->route('login')->with('success', 'Deconnexion reussie');
    }
}
