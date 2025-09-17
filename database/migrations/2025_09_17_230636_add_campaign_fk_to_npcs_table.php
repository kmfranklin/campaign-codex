<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('npcs', function (Blueprint $table) {
            // Only add the FK if it doesn't already exist
            $table->foreign('campaign_id')
                  ->references('id')->on('campaigns')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('npcs', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
        });
    }
};
