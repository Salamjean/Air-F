<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonnelDashboard extends Controller
{
    public function dashboard()
    {
        $personnelId = auth('user')->id();

        $stats = [
            'total' => \App\Models\Intervention::whereHas('personnels', function ($q) use ($personnelId) {
                $q->where('users.id', $personnelId);
            })->count(),
            'completed' => \App\Models\Intervention::whereHas('personnels', function ($q) use ($personnelId) {
                $q->where('users.id', $personnelId);
            })->where('statut', 'traiter')
                ->count(),
            'pending' => \App\Models\Intervention::whereHas('personnels', function ($q) use ($personnelId) {
                $q->where('users.id', $personnelId);
            })->whereIn('statut', ['confirmer', 'traiter_incorrect'])
                ->count(),
        ];

        $recentInterventions = \App\Models\Intervention::whereHas('personnels', function ($q) use ($personnelId) {
            $q->where('users.id', $personnelId);
        })->with(['prestataire'])
            ->latest()
            ->take(5)
            ->get();

        return view('personnel.dashboard', compact('stats', 'recentInterventions'));
    }

    public function logout()
    {
        auth('user')->logout();
        return redirect()->route('login');
    }
}
