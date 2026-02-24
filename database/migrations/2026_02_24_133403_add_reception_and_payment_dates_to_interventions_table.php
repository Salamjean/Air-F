<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            $table->timestamp('date_reception_finance')->nullable()->after('date_soumission_finance');
            $table->timestamp('date_paiement_effectif')->nullable()->after('date_paiement_prevue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            $table->dropColumn(['date_reception_finance', 'date_paiement_effectif']);
        });
    }
};
