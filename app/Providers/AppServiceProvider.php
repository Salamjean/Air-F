<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        \Carbon\Carbon::setLocale('fr');

        \Illuminate\Support\Facades\View::composer([
            'admin.layouts.sidebar',
            'financier.layouts.sidebar',
            'prestataire.layouts.sidebar',
            'responsable.layouts.sidebar',
            'personnel.layouts.sidebar'
        ], function ($view) {
            $userId = auth('user')->id();

            // General counts for Admin
            $countValider = \App\Models\Intervention::whereIn('statut', ['valider', 'rejeter'])->count();
            $countEnvoie = \App\Models\Intervention::where('statut', 'envoyer')->count();
            $countConfirmer = \App\Models\Intervention::where('statut', 'confirmer')->count();
            $countTraiter = \App\Models\Intervention::where('statut', 'traiter')->count();
            $countAccord = \App\Models\Intervention::where('statut', 'accord')->count();
            $countFinance = \App\Models\Intervention::whereIn('statut', ['finance', 'receptionne', 'attente_paiement'])->count();
            $countDevis = \App\Models\Intervention::where('statut', 'devis')->count();
            $countPayerTotal = \App\Models\Intervention::where('statut', 'payer')->count();

            // Counts for Financier
            $countFinanceAssign = \App\Models\Intervention::whereIn('statut', ['finance', 'receptionne', 'attente_paiement'])->where('financier_id', $userId)->count();
            $countPayerAssign = \App\Models\Intervention::where('statut', 'payer')->where('financier_id', $userId)->count();

            // Counts for Prestataire
            $countPayerPrestataire = \App\Models\Intervention::where('statut', 'payer')->where('prestataire_id', $userId)->count();
            $countFacturePrestataire = \App\Models\Intervention::where('statut', 'facture')->where('prestataire_id', $userId)->count();
            $countFinancePrestataire = \App\Models\Intervention::whereIn('statut', ['finance', 'receptionne', 'attente_paiement'])->where('prestataire_id', $userId)->count();
            $countAccordPrestataire = \App\Models\Intervention::where('statut', 'accord')->where('prestataire_id', $userId)->count();
            $countEnAttentePrestataire = \App\Models\Intervention::where('statut', 'en_attente')->where('prestataire_id', $userId)->count();
            $countValiderPrestataire = \App\Models\Intervention::where('statut', 'confirmer')->where('prestataire_id', $userId)->count();
            $countRejeterPrestataire = \App\Models\Intervention::where('statut', 'rejeter')->where('prestataire_id', $userId)->count();
            $countDevisAttentePrestataire = \App\Models\Intervention::where('statut', 'traiter')->where('prestataire_id', $userId)->count();
            $countDevisHistoriquePrestataire = \App\Models\Intervention::where('prestataire_id', $userId)
                ->where(function ($q) {
                    $q->where('montant_estimatif', '>', 0)
                        ->orWhereNotNull('devis_path');
                })->count();

            // Counts for Responsable
            $countEnvoieResponsable = \App\Models\Intervention::where('statut', 'envoyer')->count(); // Pool global

            $countConfirmerResponsable = \App\Models\Intervention::where('statut', 'facture')
                ->count();

            $countAccordResponsable = \App\Models\Intervention::whereIn('statut', ['accord', 'finance', 'receptionne', 'attente_paiement'])
                ->count();

            $countPayerResponsable = \App\Models\Intervention::where('statut', 'payer')
                ->count();

            $countDevisResponsable = \App\Models\Intervention::where('statut', 'devis')
                ->count();

            $countTraiterResponsable = \App\Models\Intervention::where('statut', 'traiter')
                ->count();

            // Counts for Personnel
            $countATraiterPersonnel = \App\Models\Intervention::whereHas('personnels', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })->whereIn('statut', ['confirmer', 'traiter_incorrect'])->count();

            $countHistoriquePersonnel = \App\Models\Intervention::whereHas('personnels', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })->whereIn('statut', ['traiter', 'devis', 'accord', 'finance', 'receptionne', 'attente_paiement', 'payer'])->count();

            $view->with(compact(
                'countValider',
                'countEnvoie',
                'countConfirmer',
                'countTraiter',
                'countAccord',
                'countFinance',
                'countDevis',
                'countPayerTotal',
                'countFinanceAssign',
                'countPayerAssign',
                'countPayerPrestataire',
                'countFacturePrestataire',
                'countFinancePrestataire',
                'countAccordPrestataire',
                'countEnAttentePrestataire',
                'countValiderPrestataire',
                'countRejeterPrestataire',
                'countDevisAttentePrestataire',
                'countDevisHistoriquePrestataire',
                'countEnvoieResponsable',
                'countConfirmerResponsable',
                'countAccordResponsable',
                'countPayerResponsable',
                'countDevisResponsable',
                'countTraiterResponsable',
                'countATraiterPersonnel',
                'countHistoriquePersonnel'
            ));
        });
    }
}
