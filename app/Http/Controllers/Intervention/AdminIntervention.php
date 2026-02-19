<?php

namespace App\Http\Controllers\Intervention;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Site;
use App\Models\User;
use App\Notifications\ConfirmationIntervention;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification; // Import Facade if needed, or use Notifiable on User/route
use Illuminate\Support\Str;

class AdminIntervention extends Controller
{
    public function index(Request $request)
    {
        $query = Intervention::query();

        // Filters
        if ($request->has('statut') && !empty($request->statut)) {
            $query->where('statut', $request->statut);
        }
        if ($request->has('prestataire_id') && !empty($request->prestataire_id)) {
            $query->where('prestataire_id', $request->prestataire_id);
        }
        if ($request->has('date_debut') && !empty($request->date_debut)) {
            $query->whereDate('date_debut', '>=', $request->date_debut);
        }
        if ($request->has('date_fin') && !empty($request->date_fin)) {
            $query->whereDate('date_fin', '<=', $request->date_fin);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();

        // Statistics (Global)
        $total = Intervention::count();
        $en_attente = Intervention::where('statut', 'en_attente')->count();
        $valider = Intervention::whereIn('statut', ['valider', 'rejeter'])->count();
        $terminer = Intervention::where('statut', 'terminer')->count();

        // For filter dropdowns
        $prestataires = User::where('role', 'prestataire')->get();

        return view('admin.interventions.index', compact('interventions', 'total', 'en_attente', 'valider', 'terminer', 'prestataires'));
    }

    public function create()
    {
        $prestataires = User::where('role', 'prestataire')->get();
        $sites = Site::all();
        $forfaits = \App\Models\Forfait::with('tasks')->get();
        return view('admin.interventions.create', compact('prestataires', 'sites', 'forfaits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:interventions,code',
            'libelle' => 'required',
            'date_debut' => 'nullable|date',
            'description' => 'required|string',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'prestataire_id' => 'required|exists:users,id',
            'forfait_id' => 'nullable|exists:forfaits,id',
            'forfait_task_ids' => 'nullable|array',
            'forfait_task_ids.*' => 'exists:forfait_tasks,id',
            'montant' => 'nullable|numeric',
            'document_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'document_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'code.required' => 'Le code est requis',
            'code.unique' => 'Le code existe déjà',
            'libelle.required' => 'Le libellé est requis',
            'description.required' => 'La description est requise',
            'date_debut.required' => 'La date de début est requise',
            'date_fin.required' => 'La date de fin est requise',
            'date_fin.after_or_equal' => 'La date de fin doit être supérieure ou égale à la date de début',
            'prestataire_id.required' => 'Le prestataire est requis',
            'prestataire_id.exists' => 'Le prestataire n\'existe pas',
        ]);

        try {
            $intervention = new Intervention();
            $intervention->reference = 'REF-' . strtoupper(Str::random(10));
            $intervention->code = $request->code;
            $intervention->libelle = $request->libelle;
            $intervention->description = $request->description;
            $intervention->date_debut = $request->date_debut;
            $intervention->date_fin = $request->date_fin;
            $intervention->prestataire_id = $request->prestataire_id;
            $intervention->site_id = $request->site_id;
            $intervention->admin_id = auth('user')->id();
            $intervention->statut = 'en_attente';
            $intervention->forfait_id = $request->forfait_id;

            // Set montant from forfait if not provided
            if ($request->filled('forfait_id') && !$request->filled('montant')) {
                $forfait = \App\Models\Forfait::find($request->forfait_id);
                $intervention->montant = $forfait->price;
            } elseif ($request->filled('montant')) {
                $intervention->montant = $request->montant;
            }

            // Handle file uploads
            if ($request->hasFile('document_1')) {
                $intervention->document_1 = $request->file('document_1')->store('interventions/documents', 'public');
            }
            if ($request->hasFile('document_2')) {
                $intervention->document_2 = $request->file('document_2')->store('interventions/documents', 'public');
            }

            $intervention->save();

            // Sync forfait tasks
            if ($request->has('forfait_task_ids')) {
                $intervention->forfaitTasks()->sync($request->forfait_task_ids);
            }

            Log::info('Intervention créée : ' . $intervention->reference . ' par Admin ID: ' . auth('user')->id());

            return redirect()->route('admin.interventions.index')->with('success', 'Intervention créée avec succès');
        } catch (Exception $e) {
            Log::error('Erreur lors de la création de l\'intervention : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la création de l\'intervention.')->withInput();
        }
    }

    public function show(Intervention $intervention)
    {
        $intervention->load(['personnels', 'prestataire', 'forfait', 'forfaitTasks']);
        return view('admin.interventions.details', compact('intervention'));
    }

    public function edit(Intervention $intervention)
    {
        $prestataires = User::where('role', 'prestataire')->get();
        $sites = Site::all();
        $forfaits = \App\Models\Forfait::with('tasks')->get();
        $intervention->load('forfaitTasks');
        return view('admin.interventions.edit', compact('intervention', 'prestataires', 'sites', 'forfaits'));
    }

    public function update(Request $request, Intervention $intervention)
    {
        $request->validate([
            'code' => 'required|unique:interventions,code,' . $intervention->id,
            'libelle' => 'required',
            'date_debut' => 'nullable|date',
            'description' => 'required|string',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'prestataire_id' => 'required|exists:users,id',
            'forfait_id' => 'nullable|exists:forfaits,id',
            'forfait_task_ids' => 'nullable|array',
            'forfait_task_ids.*' => 'exists:forfait_tasks,id',
            'montant' => 'nullable|numeric',
            'document_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'document_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'code.required' => 'Le code est requis',
            'code.unique' => 'Le code existe déjà',
            'libelle.required' => 'Le libellé est requis',
            'description.required' => 'La description est requise',
            'date_debut.required' => 'La date de début est requise',
            'date_fin.required' => 'La date de fin est requise',
            'date_fin.after_or_equal' => 'La date de fin doit être supérieure ou égale à la date de début',
            'prestataire_id.required' => 'Le prestataire est requis',
            'prestataire_id.exists' => 'Le prestataire n\'existe pas',
        ]);

        try {
            $intervention->code = $request->code;
            $intervention->libelle = $request->libelle;
            $intervention->description = $request->description;
            $intervention->date_debut = $request->date_debut;
            $intervention->date_fin = $request->date_fin;
            $intervention->prestataire_id = $request->prestataire_id;
            $intervention->site_id = $request->site_id;
            $intervention->forfait_id = $request->forfait_id;

            // Handle montant
            if ($request->filled('montant')) {
                $intervention->montant = $request->montant;
            } elseif ($request->filled('forfait_id')) {
                $forfait = \App\Models\Forfait::find($request->forfait_id);
                $intervention->montant = $forfait->price;
            }

            // Handle file uploads
            if ($request->hasFile('document_1')) {
                $intervention->document_1 = $request->file('document_1')->store('interventions/documents', 'public');
            }
            if ($request->hasFile('document_2')) {
                $intervention->document_2 = $request->file('document_2')->store('interventions/documents', 'public');
            }

            // Reset status if it was rejected
            if ($intervention->statut === 'rejeter') {
                $intervention->statut = 'en_attente';
                $intervention->motif_refus = null;
                Log::info('Intervention ' . $intervention->reference . ' remise en attente après modification admin.');
            }

            $intervention->save();

            // Sync forfait tasks
            if ($request->has('forfait_task_ids')) {
                $intervention->forfaitTasks()->sync($request->forfait_task_ids);
            } else {
                $intervention->forfaitTasks()->detach();
            }

            Log::info('Intervention modifiée : ' . $intervention->reference . ' par Admin ID: ' . auth('user')->id());

            return redirect()->route('admin.interventions.index')->with('success', 'Intervention mise à jour avec succès');
        } catch (Exception $e) {
            Log::error('Erreur lors de la modification de l\'intervention : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la modification de l\'intervention.')->withInput();
        }
    }

    public function destroy(Intervention $intervention)
    {
        $intervention->delete();
        return redirect()->route('admin.interventions.index');
    }

    public function archives()
    {
        $interventions = Intervention::all();
        return view('admin.interventions.archives', compact('interventions'));
    }

    public function restore(Intervention $intervention)
    {
        $intervention->restore();
        return redirect()->route('admin.interventions.index');
    }
    public function valider(Request $request)
    {
        $query = Intervention::whereIn('statut', ['valider', 'rejeter'])->with(['personnels', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('admin.interventions.valider', compact('interventions'));
    }

    public function envoie(Request $request)
    {
        $query = Intervention::where('statut', 'envoyer')->with(['personnels', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('admin.interventions.envoie', compact('interventions'));
    }

    public function confirmer(Request $request)
    {
        $query = Intervention::where('statut', 'confirmer')->with(['personnels', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('admin.interventions.confirmer', compact('interventions'));
    }

    public function details(Intervention $intervention)
    {
        $intervention->load(['personnels', 'prestataire', 'forfait', 'forfaitTasks']);
        return view('admin.interventions.details', compact('intervention'));
    }

    public function envoyer(Intervention $intervention)
    {
        try {
            $intervention->statut = 'envoyer';
            $intervention->save();

            Log::info('Intervention envoyée par Admin : ' . $intervention->reference);
            return back()->with('success', 'Intervention envoyée avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'envoye de l\'intervention : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function traiter(Intervention $intervention)
    {
        try {
            $intervention->statut = 'traiter';
            $intervention->save();

            Log::info('Intervention traitée par Admin : ' . $intervention->reference);
            return redirect()->route('admin.interventions.confirmer')->with('success', 'Intervention marquée comme traitée avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors du traitement de l\'intervention : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function traitees(Request $request)
    {
        $query = Intervention::where('statut', 'traiter')->with(['personnels', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('admin.interventions.traitees', compact('interventions'));
    }

    public function devis(Request $request)
    {
        $query = Intervention::where('statut', 'devis')->with(['personnels', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('admin.interventions.devis', compact('interventions'));
    }

    public function accordees(Request $request)
    {
        $query = Intervention::whereIn('statut', ['accord'])->with(['personnels', 'prestataire', 'responsable']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        $financiers = User::where('role', 'finance')->get();
        return view('admin.interventions.accordees', compact('interventions', 'financiers'));
    }

    public function assignFinance(Request $request, Intervention $intervention)
    {
        $request->validate([
            'financier_id' => 'required|exists:users,id',
        ]);

        try {
            $intervention->financier_id = $request->financier_id;
            $intervention->statut = 'finance';
            $intervention->date_soumission_finance = now();
            $intervention->save();

            Log::info('Intervention assignée au financier ID: ' . $request->financier_id . ' - Ref: ' . $intervention->reference);
            return back()->with('success', 'Intervention envoyée à la finance avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'assignation à la finance : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function finance(Request $request)
    {
        $query = Intervention::where('statut', 'finance')->with(['personnels', 'prestataire', 'financier']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('admin.interventions.finance', compact('interventions'));
    }

    public function payees(Request $request)
    {
        $query = Intervention::where('statut', 'payer')->with(['personnel', 'prestataire']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        $interventions = $query->latest()->get();
        return view('admin.interventions.payees', compact('interventions'));
    }

    public function confirmerDirectement(Request $request, Intervention $intervention)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            $intervention->statut = 'confirmer';
            $intervention->save();

            // Send Email Notification
            Notification::route('mail', $request->email)
                ->notify(new ConfirmationIntervention($intervention, $request->message));

            Log::info('Intervention confirmée directement par Admin : ' . $intervention->reference . ' - Email envoyé à : ' . $request->email);
            return back()->with('success', 'Intervention confirmée et email envoyé avec succès.');
        } catch (Exception $e) {
            Log::error('Erreur lors de la confirmation directe : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la confirmation : ' . $e->getMessage());
        }
    }
}
