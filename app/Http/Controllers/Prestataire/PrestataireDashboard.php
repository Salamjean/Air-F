<?php

namespace App\Http\Controllers\Prestataire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrestataireDashboard extends Controller
{
    public function dashboard()
    {
        $prestataireId = auth('user')->id();

        $stats = [
            'en_attente' => \App\Models\Intervention::where('prestataire_id', $prestataireId)
                ->where('statut', 'en_attente')
                ->count(),
            'validees' => \App\Models\Intervention::where('prestataire_id', $prestataireId)
                ->where('statut', 'valider')
                ->count(),
            'finance' => \App\Models\Intervention::where('prestataire_id', $prestataireId)
                ->where('statut', 'finance')
                ->count(),
            'payees' => \App\Models\Intervention::where('prestataire_id', $prestataireId)
                ->where('statut', 'payer')
                ->count(),
            'intervenues' => \App\Models\Intervention::where('prestataire_id', $prestataireId)
                ->count(),
        ];

        $recentInterventions = \App\Models\Intervention::where('prestataire_id', $prestataireId)
            ->with(['personnel'])
            ->latest()
            ->take(5)
            ->get();

        return view('prestataire.dashboard', compact('stats', 'recentInterventions'));
    }

    public function logout()
    {
        auth('user')->logout();
        return redirect()->route('login')->with('success', 'Vous êtes déconnecté.');
    }
}
