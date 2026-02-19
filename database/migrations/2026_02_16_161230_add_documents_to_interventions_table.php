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
            $table->string('document_1')->nullable()->after('devis_path');
            $table->string('document_2')->nullable()->after('document_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interventions', function (Blueprint $table) {
            $table->dropColumn(['document_1', 'document_2']);
        });
    }
};
