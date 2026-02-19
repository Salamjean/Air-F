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
            $table->string('rapport_path')->nullable();
            $table->text('rapport_commentaire')->nullable();
            $table->dateTime('date_debut_reelle')->nullable();
            $table->dateTime('date_fin_reelle')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            $table->dropColumn(['rapport_path', 'rapport_commentaire', 'date_debut_reelle', 'date_fin_reelle']);
        });
    }
};
