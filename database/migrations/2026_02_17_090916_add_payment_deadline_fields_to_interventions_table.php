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
            $table->timestamp('date_soumission_finance')->nullable()->after('financier_id');
            $table->integer('delai_paiement')->nullable()->after('date_soumission_finance');
            $table->date('date_paiement_prevue')->nullable()->after('delai_paiement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            $table->dropColumn(['date_soumission_finance', 'delai_paiement', 'date_paiement_prevue']);
        });
    }
};
