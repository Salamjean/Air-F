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
            $table->integer('stock_quantity')->default(0)->after('added_by');
            $table->integer('stock_min_alert')->default(5)->after('stock_quantity');
            $table->string('unit')->default('pièce')->after('stock_min_alert');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipements', function (Blueprint $table) {
            $table->dropColumn(['stock_quantity', 'stock_min_alert', 'unit']);
        });
    }
};
