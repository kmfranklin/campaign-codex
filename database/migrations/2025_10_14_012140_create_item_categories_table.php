<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('item_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();   // e.g. "weapon"
            $table->string('name');             // e.g. "Weapon"
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('item_categories');
    }
};
