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
        Schema::table('equipements', function (Blueprint $table) {
            $table->string('longueur')->nullable()->after('name');
            $table->string('type')->nullable()->after('longueur');
            $table->string('numero_bien')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipements', function (Blueprint $table) {
            $table->dropColumn(['longueur', 'type', 'numero_bien']);
        });
    }
};
