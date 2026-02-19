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
            if (!Schema::hasColumn('interventions', 'rapport_path')) {
                $table->string('rapport_path')->nullable();
            }
            if (!Schema::hasColumn('interventions', 'rapport_commentaire')) {
                $table->text('rapport_commentaire')->nullable();
            }
            if (!Schema::hasColumn('interventions', 'date_debut_reelle')) {
                $table->dateTime('date_debut_reelle')->nullable();
            }
            if (!Schema::hasColumn('interventions', 'date_fin_reelle')) {
                $table->dateTime('date_fin_reelle')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('interventions', 'rapport_path'))
                $cols[] = 'rapport_path';
            if (Schema::hasColumn('interventions', 'rapport_commentaire'))
                $cols[] = 'rapport_commentaire';
            if (Schema::hasColumn('interventions', 'date_debut_reelle'))
                $cols[] = 'date_debut_reelle';
            if (Schema::hasColumn('interventions', 'date_fin_reelle'))
                $cols[] = 'date_fin_reelle';

            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
