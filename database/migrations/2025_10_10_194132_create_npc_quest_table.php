<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('npc_quest', function (Blueprint $table) {
            $table->id();
            $table->foreignId('npc_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quest_id')->constrained()->cascadeOnDelete();

            // Optional metadata about the relationship (e.g., role in the quest)
            $table->string('role')->nullable(); // e.g., "quest_giver", "ally", "enemy"

            $table->timestamps();

            $table->unique(['npc_id', 'quest_id']); // prevent duplicates
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('npc_quest');
    }
};

