<?php

use App\Http\Controllers\Financier\FinancierDashboard;
use App\Http\Controllers\Intervention\AdminIntervention;
use App\Http\Controllers\Personnel\PersonnelController;
use App\Http\Controllers\Personnel\PersonnelDashboard;
use App\Http\Controllers\Personnel\PersonnelInterventionController;
use App\Http\Controllers\Prestataire\PrestataireDashboard;
use App\Http\Controllers\Prestataire\PrestataireIntervention;
use App\Http\Controllers\Responsable\ResponsableDashboard;
use App\Http\Controllers\Responsable\ResponsableIntervention;
use App\Http\Controllers\User\UserAuthenticate;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserDashboard;
use App\Http\Controllers\Admin\EquipementController;
use App\Http\Controllers\Admin\EquipementCategoryController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\ForfaitController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home.accueil');
// });

//Les routes de gestion de l'admin(M.KADIO)
Route::prefix('/')->group(function () {
    Route::get('/', [UserAuthenticate::class, 'login'])->name('login');
    Route::post('/', [UserAuthenticate::class, 'handleLogin'])->name('user.login');

    // Mot de passe oublié
    Route::get('/forgot-password', [UserAuthenticate::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [UserAuthenticate::class, 'handleForgotPassword'])->name('password.email');
    Route::get('/reset-password/{email}', [UserAuthenticate::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [UserAuthenticate::class, 'handleResetPassword'])->name('password.update');
});

Route::middleware(['auth:user', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [UserDashboard::class, 'dashboard'])->name('admin.dashboard');
    Route::match(['get', 'post'], '/logout', [UserDashboard::class, 'logout'])->name('admin.logout');

    //les routes de gestions des utilisateurs
    Route::middleware('superadmin')->prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/archives', [UserController::class, 'archives'])->name('admin.users.archives');
        Route::patch('/{user}/restore', [UserController::class, 'restore'])->name('admin.users.restore');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/{user}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    //Les routes de gestion d'intervention
    Route::prefix('interventions')->group(function () {
        Route::get('/', [AdminIntervention::class, 'index'])->name('admin.interventions.index');
        Route::get('/valider', [AdminIntervention::class, 'valider'])->name('admin.interventions.valider');
        Route::get('/envoie', [AdminIntervention::class, 'envoie'])->name('admin.interventions.envoie');
        Route::get('/confirmer', [AdminIntervention::class, 'confirmer'])->name('admin.interventions.confirmer');
        Route::get('/traitees', [AdminIntervention::class, 'traitees'])->name('admin.interventions.traitees');
        Route::get('/devis', [AdminIntervention::class, 'devis'])->name('admin.interventions.devis');
        Route::get('/accordees', [AdminIntervention::class, 'accordees'])->name('admin.interventions.accordees');
        Route::get('/finance', [AdminIntervention::class, 'finance'])->name('admin.interventions.finance');
        Route::post('/{intervention}/assign-finance', [AdminIntervention::class, 'assignFinance'])->name('admin.interventions.assign_finance');
        Route::get('/create', [AdminIntervention::class, 'create'])->name('admin.interventions.create');
        Route::post('/', [AdminIntervention::class, 'store'])->name('admin.interventions.store');
        Route::get('/archives', [AdminIntervention::class, 'archives'])->name('admin.interventions.archives');
        Route::get('/payees', [AdminIntervention::class, 'payees'])->name('admin.interventions.payees');
        Route::get('/{intervention}', [AdminIntervention::class, 'show'])->name('admin.interventions.show');
        Route::get('/{intervention}/details', [AdminIntervention::class, 'details'])->name('admin.interventions.details');
        Route::post('/{intervention}/envoyer', [AdminIntervention::class, 'envoyer'])->name('admin.interventions.envoyer');
        Route::post('/{intervention}/traiter', [AdminIntervention::class, 'traiter'])->name('admin.interventions.traiter');
        Route::post('/{intervention}/confirmer-directement', [AdminIntervention::class, 'confirmerDirectement'])->name('admin.interventions.confirmerDirectement');
        Route::get('/{intervention}/edit', [AdminIntervention::class, 'edit'])->name('admin.interventions.edit');
        Route::put('/{intervention}', [AdminIntervention::class, 'update'])->name('admin.interventions.update');
        Route::delete('/{intervention}', [AdminIntervention::class, 'destroy'])->name('admin.interventions.destroy');
        Route::patch('/{intervention}/restore', [AdminIntervention::class, 'restore'])->name('admin.interventions.restore');
    });

    // Gestion des équipements et catégories
    Route::middleware('superadmin')->group(function () {
        Route::get('equipements/history', [EquipementController::class, 'history'])->name('admin.equipements.history');
        Route::get('equipements/export', [EquipementController::class, 'export'])->name('admin.equipements.export');
        Route::post('equipements/{equipement}/recharge', [EquipementController::class, 'recharge'])->name('admin.equipements.recharge');
        Route::resource('equipements', EquipementController::class, ['as' => 'admin'])->names([
            'index' => 'admin.equipements.index',
            'create' => 'admin.equipements.create',
            'store' => 'admin.equipements.store',
            'edit' => 'admin.equipements.edit',
            'update' => 'admin.equipements.update',
            'destroy' => 'admin.equipements.destroy',
        ]);
        Route::resource('equipement-categories', EquipementCategoryController::class)->parameters([
            'equipement-categories' => 'category'
        ])->names([
                    'index' => 'admin.categories.index',
                    'create' => 'admin.categories.create',
                    'store' => 'admin.categories.store',
                    'edit' => 'admin.categories.edit',
                    'update' => 'admin.categories.update',
                    'destroy' => 'admin.categories.destroy',
                ]);

        Route::resource('sites', SiteController::class)->names([
            'index' => 'admin.sites.index',
            'create' => 'admin.sites.create',
            'store' => 'admin.sites.store',
            'edit' => 'admin.sites.edit',
            'update' => 'admin.sites.update',
            'destroy' => 'admin.sites.destroy',
        ]);

        Route::resource('forfaits', ForfaitController::class)->names([
            'index' => 'admin.forfaits.index',
            'create' => 'admin.forfaits.create',
            'store' => 'admin.forfaits.store',
            'edit' => 'admin.forfaits.edit',
            'update' => 'admin.forfaits.update',
            'destroy' => 'admin.forfaits.destroy',
        ]);
    });
});

//Les routes de gestion du prestataire
Route::middleware(['auth:user', 'prestataire'])->prefix('prestataire')->group(function () {
    Route::get('/dashboard', [PrestataireDashboard::class, 'dashboard'])->name('prestataire.dashboard');
    Route::match(['get', 'post'], '/logout', [PrestataireDashboard::class, 'logout'])->name('prestataire.logout');

    // Gestion des interventions
    Route::prefix('interventions')->group(function () {
        Route::get('/', [PrestataireIntervention::class, 'index'])->name('prestataire.interventions.index');
        Route::post('/{intervention}/validate', [PrestataireIntervention::class, 'validateIntervention'])->name('prestataire.interventions.validate');
        Route::post('/{intervention}/refuse', [PrestataireIntervention::class, 'refuseIntervention'])->name('prestataire.interventions.refuse');
        Route::get('/en_attente', [PrestataireIntervention::class, 'enAttente'])->name('prestataire.interventions.en_attente');
        Route::get('/valider', [PrestataireIntervention::class, 'valider'])->name('prestataire.interventions.valider');
        Route::get('/facturees', [PrestataireIntervention::class, 'facturees'])->name('prestataire.interventions.facturees');
        Route::get('/accordees', [PrestataireIntervention::class, 'accordees'])->name('prestataire.interventions.accordees');
        Route::get('/finance', [PrestataireIntervention::class, 'finance'])->name('prestataire.interventions.finance');
        Route::get('/rejeter', [PrestataireIntervention::class, 'rejeter'])->name('prestataire.interventions.rejeter');
        Route::get('/historique', [PrestataireIntervention::class, 'historique'])->name('prestataire.interventions.historique');

        // Devis Management
        Route::prefix('devis')->name('prestataire.interventions.devis.')->group(function () {
            Route::get('/attente', [PrestataireIntervention::class, 'devisAttente'])->name('attente');
            Route::get('/historique', [PrestataireIntervention::class, 'devisHistorique'])->name('historique');
            Route::post('/{intervention}/soumettre', [PrestataireIntervention::class, 'soumettreDevis'])->name('soumettre');
            Route::post('/{intervention}/soumettre-facture-definitive', [PrestataireIntervention::class, 'soumettreFactureDefinitive'])->name('soumettre_facture_definitive');
            Route::post('/{intervention}/rejeter-rapport', [PrestataireIntervention::class, 'rejeterRapport'])->name('rejeter_rapport');
        });

        Route::get('/{intervention}/details', [PrestataireIntervention::class, 'details'])->name('prestataire.interventions.details');
    });

    //Les routes de gestion du personnel du prestataire
    Route::prefix('personnel')->group(function () {
        Route::get('/', [PersonnelController::class, 'index'])->name('prestataire.personnel.index');
        Route::get('/create', [PersonnelController::class, 'create'])->name('prestataire.personnel.create');
        Route::post('/', [PersonnelController::class, 'store'])->name('prestataire.personnel.store');
        Route::get('/{personnel}', [PersonnelController::class, 'show'])->name('prestataire.personnel.show');
        Route::get('/{personnel}/edit', [PersonnelController::class, 'edit'])->name('prestataire.personnel.edit');
        Route::put('/{personnel}', [PersonnelController::class, 'update'])->name('prestataire.personnel.update');
        Route::delete('/{personnel}', [PersonnelController::class, 'destroy'])->name('prestataire.personnel.destroy');
        Route::get('/archives', [PersonnelController::class, 'archives'])->name('prestataire.personnel.archives');
        Route::patch('/{personnel}/restore', [PersonnelController::class, 'restore'])->name('prestataire.personnel.restore');
    });
});

//Les routes de gestion du responsable
Route::middleware(['auth:user', 'responsable'])->prefix('responsable')->group(function () {
    Route::get('/dashboard', [ResponsableDashboard::class, 'dashboard'])->name('responsable.dashboard');
    Route::match(['get', 'post'], '/logout', [ResponsableDashboard::class, 'logout'])->name('responsable.logout');

    // Gestion des interventions pour le responsable
    Route::prefix('interventions')->group(function () {
        Route::get('/envoyees', [ResponsableIntervention::class, 'envoyees'])->name('responsable.interventions.envoyees');
        Route::get('/confirmer', [ResponsableIntervention::class, 'confirmer'])->name('responsable.interventions.confirmer');
        Route::get('/accordees', [ResponsableIntervention::class, 'accordees'])->name('responsable.interventions.accordees');
        Route::post('/{intervention}/assign-finance', [ResponsableIntervention::class, 'assignFinance'])->name('responsable.interventions.assign_finance');
        Route::get('/{intervention}/details', [ResponsableIntervention::class, 'details'])->name('responsable.interventions.details');
        Route::post('/{intervention}/confirm', [ResponsableIntervention::class, 'confirmAction'])->name('responsable.interventions.confirmAction');
        Route::get('/historique', [ResponsableIntervention::class, 'historique'])->name('responsable.interventions.historique');
    });
});

//Les routes de gestion du financier
Route::middleware(['auth:user', 'financier'])->prefix('financier')->group(function () {
    Route::get('/dashboard', [FinancierDashboard::class, 'dashboard'])->name('financier.dashboard');
    Route::match(['get', 'post'], '/logout', [FinancierDashboard::class, 'logout'])->name('financier.logout');

    Route::prefix('interventions')->name('financier.interventions.')->group(function () {
        Route::get('/paiements', [App\Http\Controllers\Financier\FinancierInterventionController::class, 'index'])->name('index');
        Route::get('/historique', [App\Http\Controllers\Financier\FinancierInterventionController::class, 'historique'])->name('historique');
        Route::get('/{intervention}/paiement-detail', [App\Http\Controllers\Financier\FinancierInterventionController::class, 'paiementDetail'])->name('paiement_detail');
        Route::post('/{intervention}/payer', [App\Http\Controllers\Financier\FinancierInterventionController::class, 'payer'])->name('payer');
    });

    // Gestion des utilisateurs par le financier
    Route::prefix('users')->name('financier.users.')->group(function () {
        Route::get('/', [App\Http\Controllers\Financier\FinancierUserController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Financier\FinancierUserController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Financier\FinancierUserController::class, 'store'])->name('store');
        Route::delete('/{user}', [App\Http\Controllers\Financier\FinancierUserController::class, 'destroy'])->name('destroy');
    });
});

//Les routes de gestion du personnel (espace personnel)
Route::middleware(['auth:user', 'personnel'])->group(function () {
    // Espace Personnel
    Route::prefix('personnel')->name('personnel.')->group(function () {
        Route::get('/dashboard', [PersonnelDashboard::class, 'dashboard'])->name('dashboard');

        // Interventions
        Route::prefix('interventions')->name('interventions.')->group(function () {
            Route::get('/', [PersonnelInterventionController::class, 'index'])->name('index');
            Route::get('/historique', [PersonnelInterventionController::class, 'traitees'])->name('historique');
            Route::get('/{intervention}', [PersonnelInterventionController::class, 'show'])->name('show');
            Route::get('/{intervention}/traitement', [PersonnelInterventionController::class, 'edit'])->name('edit');
            Route::put('/{intervention}/update', [PersonnelInterventionController::class, 'update'])->name('update');
        });

        Route::post('/logout', [PersonnelDashboard::class, 'logout'])->name('logout');
    });
});

//Les routes pour definir les accès 
Route::get('/validate-user-account/{email}', [UserAuthenticate::class, 'defineAccess']);
Route::post('/validate-user-account/{email}', [UserAuthenticate::class, 'submitDefineAccess'])->name('user.validate');
