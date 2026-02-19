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
        Schema::create('forfaits', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // F1, F2, F3, F4
            $table->string('label');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        Schema::create('forfait_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forfait_id')->constrained()->onDelete('cascade');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('intervention_forfait_task', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')->constrained()->onDelete('cascade');
            $table->foreignId('forfait_task_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('intervention_forfait_task');
        Schema::dropIfExists('forfait_tasks');
        Schema::dropIfExists('forfaits');
    }
};
