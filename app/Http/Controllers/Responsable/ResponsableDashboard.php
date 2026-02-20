<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponsableDashboard extends Controller
{
    public function dashboard()
    {
        $userId = auth('user')->id();

        $stats = [
            'total' => \App\Models\Intervention::count(),
            'envoyees' => \App\Models\Intervention::where('statut', 'envoyer')->count(), // Pool global
            'traitees' => \App\Models\Intervention::where('statut', 'traiter')->count(),
            'devis' => \App\Models\Intervention::where('statut', 'devis')->count(),
            'confirmer' => \App\Models\Intervention::where('statut', 'facture')->count(),
            'accordees' => \App\Models\Intervention::where('statut', 'accord')->count(),
            'payees' => \App\Models\Intervention::where('statut', 'payer')->count(),
        ];

        $recentInterventions = \App\Models\Intervention::latest()
            ->take(5)
            ->get();

        return view('responsable.dashboard', compact('stats', 'recentInterventions'));
    }

    public function logout()
    {
        auth('user')->logout();
        return redirect()->route('login')->with('success', 'Deconnexion reussie');
    }
}
