<?php

namespace App\Http\Controllers\Financier;

use App\Http\Controllers\Controller;
use App\Models\ResetCodePasswordUser;
use App\Models\User;
use App\Notifications\sendEmailAfterUserRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class FinancierUserController extends Controller
{
    public function index()
    {
        // On affiche tous les utilisateurs de rôle finance, avec l'information du créateur
        $users = User::where('role', 'finance')->with('creator')->get();
        return view('financier.users.index', compact('users'));
    }

    public function create()
    {
        return view('financier.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Le nom est requis',
            'prenom.required' => 'Le prénom est requis',
            'email.required' => 'L\'email est requis',
            'email.unique' => 'Cet email est déjà utilisé.',
            'contact.required' => 'Le contact est requis',
            'adresse.required' => 'L\'adresse est requise',
        ]);

        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->prenom = $request->prenom;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->role = 'finance'; // Role forcé à finance
            $user->adresse = $request->adresse;
            $user->password = Hash::make('default');
            $user->created_by = auth('user')->id(); // Traçabilité

            if ($request->hasFile('profile_picture')) {
                $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
            }
            $user->save();

            // Envoi de l'e-mail de vérification (Réutilisation de la logique existante)
            ResetCodePasswordUser::where('email', $user->email)->delete();
            $code1 = rand(1000, 4000);
            $code = $code1 . '' . $user->id;

            ResetCodePasswordUser::create([
                'code' => $code,
                'email' => $user->email,
            ]);

            Notification::route('mail', $user->email)
                ->notify(new sendEmailAfterUserRegister($code, $user->email));

            DB::commit();

            return redirect()->route('financier.users.index')->with('success', 'L\'utilisateur financier a bien été enregistré.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'enregistrement de l\'utilisateur par un financier: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Une erreur est survenue lors de l\'enregistrement.'])->withInput();
        }
    }

    public function destroy(User $user)
    {
        // Seuls les financiers peuvent être supprimés (archivés) par ici
        if ($user->role !== 'finance') {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        // Vérifier si le financier connecté est bien le créateur du compte
        if ($user->created_by !== auth('user')->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez archiver que les utilisateurs que vous avez ajoutés.');
        }

        $user->delete();
        return redirect()->route('financier.users.index')->with('success', 'Utilisateur archivé avec succès.');
    }
}
