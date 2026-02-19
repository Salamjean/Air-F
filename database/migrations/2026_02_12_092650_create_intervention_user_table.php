<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('intervention_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // This assumes 'users' table
            $table->timestamps();
        });

        // Migrate existing data
        $interventions = DB::table('interventions')->whereNotNull('personnel_id')->get();
        foreach ($interventions as $intervention) {
            DB::table('intervention_user')->insert([
                'intervention_id' => $intervention->id,
                'user_id' => $intervention->personnel_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervention_user');
    }
};
