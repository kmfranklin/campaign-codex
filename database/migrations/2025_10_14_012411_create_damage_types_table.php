<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('damage_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();   // e.g. "slashing"
            $table->string('name');             // e.g. "Slashing"
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('damage_types');
    }
};
