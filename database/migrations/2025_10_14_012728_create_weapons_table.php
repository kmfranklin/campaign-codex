<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->unique()->constrained('items')->cascadeOnDelete();

            $table->string('damage_dice')->nullable();
            $table->foreignId('damage_type_id')->nullable()->constrained('damage_types')->nullOnDelete();

            $table->decimal('range', 5, 1)->default(0);
            $table->decimal('long_range', 5, 1)->default(0);
            $table->string('distance_unit')->nullable();

            $table->boolean('is_improvised')->default(false);
            $table->boolean('is_simple')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('weapons');
    }
};
