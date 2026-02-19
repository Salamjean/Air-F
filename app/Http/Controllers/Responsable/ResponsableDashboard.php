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
            'total' => \App\Models\Intervention::where('responsable_id', $userId)->count(),
            'envoyees' => \App\Models\Intervention::where('statut', 'envoyer')->count(), // Pool global
            'confirmer' => \App\Models\Intervention::where('responsable_id', $userId)->where('statut', 'facture')->count(),
            'accordees' => \App\Models\Intervention::where('responsable_id', $userId)->where('statut', 'accord')->count(),
            'payees' => \App\Models\Intervention::where('responsable_id', $userId)->where('statut', 'payer')->count(),
        ];

        $recentInterventions = \App\Models\Intervention::where(function ($q) use ($userId) {
            $q->where('responsable_id', $userId)
                ->orWhere('statut', 'envoyer');
        })
            ->latest()
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
