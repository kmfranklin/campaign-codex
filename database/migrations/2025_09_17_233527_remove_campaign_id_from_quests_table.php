<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('quests', function (Blueprint $table) {
            if (Schema::hasColumn('quests', 'campaign_id')) {
                $table->dropForeign(['campaign_id']);
                $table->dropColumn('campaign_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quests', function (Blueprint $table) {
            $table->foreignId('campaign_id')
                  ->nullable()
                  ->constrained('campaigns')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
        });
    }
};
