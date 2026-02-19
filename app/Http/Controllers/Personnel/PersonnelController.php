<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PersonnelController extends Controller
{
    public function index()
    {
        $personnels = User::where('prestataire_id', auth('user')->id())
            ->where('role', 'personnel')
            ->latest()
            ->get();

        return view('prestataire.personnel.index', compact('personnels'));
    }

    public function create()
    {
        return view('prestataire.personnel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $personnel = new User();
            $personnel->name = $request->name;
            $personnel->prenom = $request->prenom;
            $personnel->email = $request->email;
            $personnel->contact = $request->contact;
            $personnel->password = Hash::make($request->password);
            $personnel->role = 'personnel';
            $personnel->prestataire_id = auth('user')->id(); // Link to the connected prestataire

            $personnel->save();

            return redirect()->route('prestataire.personnel.index')->with('success', 'Personnel ajouté avec succès.');

        } catch (Exception $e) {
            Log::error('Erreur création personnel: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la création.')->withInput();
        }
    }

    public function edit(User $personnel)
    {
        // Security check: ensure the personnel belongs to the authenticated prestataire
        if ($personnel->prestataire_id !== auth('user')->id()) {
            abort(403, 'Accès non autorisé');
        }

        return view('prestataire.personnel.edit', compact('personnel'));
    }

    public function update(Request $request, User $personnel)
    {
        if ($personnel->prestataire_id !== auth('user')->id()) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $personnel->id,
            'contact' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $personnel->name = $request->name;
            $personnel->prenom = $request->prenom;
            $personnel->email = $request->email;
            $personnel->contact = $request->contact;

            if ($request->filled('password')) {
                $personnel->password = Hash::make($request->password);
            }

            $personnel->save();

            return redirect()->route('prestataire.personnel.index')->with('success', 'Personnel mis à jour avec succès.');

        } catch (Exception $e) {
            Log::error('Erreur modification personnel: ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la modification.')->withInput();
        }
    }

    public function destroy(User $personnel)
    {
        if ($personnel->prestataire_id !== auth('user')->id()) {
            abort(403, 'Accès non autorisé');
        }

        try {
            $personnel->delete();
            return redirect()->route('prestataire.personnel.index')->with('success', 'Personnel archivé avec succès.');
        } catch (Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression.');
        }
    }

    public function archives()
    {
        $personnels = User::onlyTrashed()
            ->where('prestataire_id', auth('user')->id())
            ->where('role', 'personnel')
            ->latest()
            ->get();

        return view('prestataire.personnel.archives', compact('personnels'));
    }

    public function restore($id)
    {
        try {
            $personnel = User::onlyTrashed()->where('id', $id)->firstOrFail();

            if ($personnel->prestataire_id !== auth('user')->id()) {
                abort(403, 'Accès non autorisé');
            }

            $personnel->restore();
            return redirect()->route('prestataire.personnel.archives')->with('success', 'Personnel restauré avec succès.');
        } catch (Exception $e) {
            return back()->with('error', 'Erreur lors de la restauration.');
        }
    }
}
