<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboard extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => \App\Models\User::where('role', '!=', 'admin')->count(),
            'interventions' => \App\Models\Intervention::count(),
            'equipements' => \App\Models\Equipement::count(),
            'personnel' => \App\Models\User::where('role', 'personnel')->count(),
            'prestataire' => \App\Models\User::where('role', 'prestataire')->count(),
            // Status specifics
            'valider' => \App\Models\Intervention::where('statut', 'valider')->count(),
            'confirmer' => \App\Models\Intervention::where('statut', 'confirmer')->count(),
            'payer' => \App\Models\Intervention::where('statut', 'payer')->count(),
            'devis' => \App\Models\Intervention::where('statut', 'devis')->count(),
            'accord' => \App\Models\Intervention::where('statut', 'accord')->count(),
            'finance' => \App\Models\Intervention::where('statut', 'finance')->count(),
        ];

        $recentInterventions = \App\Models\Intervention::with(['prestataire', 'personnel'])
            ->latest()
            ->take(6)
            ->get();

        // Data for Chart.js (Interventions over the last 6 months)
        $months = [];
        $counts = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->translatedFormat('M');
            $counts[] = \App\Models\Intervention::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        $chartData = [
            'labels' => $months,
            'data' => $counts
        ];

        return view('admin.dashboard', compact('stats', 'recentInterventions', 'chartData'));
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('user.login');
    }
}