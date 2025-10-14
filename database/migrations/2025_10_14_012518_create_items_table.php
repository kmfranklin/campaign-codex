<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            // Optional: track SRD source later, but keep nullable for now
            $table->unsignedBigInteger('document_id')->nullable();

            // Core identifiers
            $table->string('key')->unique();   // e.g. "srd_longsword"
            $table->string('name');
            $table->text('description')->nullable();

            // Economics
            $table->decimal('cost', 8, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();

            // Magic/attunement
            $table->boolean('is_magic_item')->default(false);
            $table->boolean('requires_attunement')->default(false);
            $table->string('attunement_requirements')->nullable();

            // Normalized references
            $table->foreignId('item_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('item_rarity_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('items');
    }
};
