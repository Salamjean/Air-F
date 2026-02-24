<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckPaymentDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:payment-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie les interventions dont le délai de paiement approche (J-5) et envoie des notifications.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Vérification des délais de paiement...');

        $interventions = \App\Models\Intervention::where('statut', 'attente_paiement')
            ->whereNotNull('date_paiement_prevue')
            ->whereNotNull('financier_id')
            ->get();

        $count = 0;
        foreach ($interventions as $intervention) {
            $datePrevue = \Carbon\Carbon::parse($intervention->date_paiement_prevue);
            $diff = now()->diffInDays($datePrevue, false);

            // Alerte à partir de J-5 et même si la date est dépassée
            if ($diff <= 5) {
                $financier = \App\Models\User::find($intervention->financier_id);
                if ($financier) {
                    $financier->notify(new \App\Notifications\PaymentDeadlineNotification($intervention));
                    $count++;
                }
            }
        }

        $this->info("{$count} notifications envoyées.");
    }
}
