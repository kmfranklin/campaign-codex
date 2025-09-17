<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            // Owner DM for MVP (explicit ownership link)
            $table->foreignId('dm_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();

            // Optional: quick index for listing DM-owned campaigns
            $table->index('dm_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
