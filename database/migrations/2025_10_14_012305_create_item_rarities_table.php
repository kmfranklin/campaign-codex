<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('item_rarities', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();   // e.g. "rare"
            $table->string('name');             // e.g. "Rare"
            $table->unsignedTinyInteger('rank')->nullable(); // for ordering
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('item_rarities');
    }
};
