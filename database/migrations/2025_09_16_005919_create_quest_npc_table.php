<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quest_npc', function (Blueprint $table) {
            // No auto-increment id; composite PK enforces uniqueness
            $table->foreignId('quest_id')
                ->constrained('quests')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('npc_id')
                ->constrained('npcs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('role'); // 'quest giver', 'rival', 'contact', etc.

            $table->timestamps();

            $table->primary(['quest_id', 'npc_id']);
            $table->index(['npc_id', 'role']);
            $table->index(['quest_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quest_npc');
    }
};
