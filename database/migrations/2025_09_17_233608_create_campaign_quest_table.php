<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaign_quest', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quest_id')->constrained()->cascadeOnDelete();
            // Optional: per‑campaign quest metadata
            $table->string('status')->default('Not Started');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_quest');
    }
};
