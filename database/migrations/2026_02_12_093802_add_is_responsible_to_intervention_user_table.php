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
        Schema::table('intervention_user', function (Blueprint $table) {
            $table->boolean('is_responsible')->default(false)->after('user_id');
        });

        // For existing assignments, we might want to mark one as responsible
        // Since we just migrated, we can mark the first user of each intervention as responsible
        $interventionIds = \DB::table('intervention_user')->distinct()->pluck('intervention_id');
        foreach ($interventionIds as $id) {
            \DB::table('intervention_user')
                ->where('intervention_id', $id)
                ->limit(1)
                ->update(['is_responsible' => true]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('intervention_user', function (Blueprint $table) {
            $table->dropColumn('is_responsible');
        });
    }
};
