<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaign_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('campaign_id')
                ->constrained('campaigns')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // role is per-campaign; we’ll use string for flexibility
            $table->string('role'); // 'dm' | 'player' (future: 'co-dm', 'observer')
            $table->timestamps();

            // Each user appears at most once per campaign
            $table->unique(['campaign_id', 'user_id']);

            // Helpful lookups
            $table->index(['user_id', 'role']);
            $table->index(['campaign_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_user');
    }
};
