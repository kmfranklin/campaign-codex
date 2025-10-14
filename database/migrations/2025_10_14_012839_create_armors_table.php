<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('armors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->unique()->constrained('items')->cascadeOnDelete();

            $table->unsignedTinyInteger('base_ac')->default(0);
            $table->boolean('adds_dex_mod')->default(true);
            $table->unsignedTinyInteger('dex_mod_cap')->nullable();
            $table->boolean('imposes_stealth_disadvantage')->default(false);
            $table->unsignedTinyInteger('strength_requirement')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('armors');
    }
};
