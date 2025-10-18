<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Variant -> base item link
            $table->foreignId('base_item_id')->nullable()->constrained('items');

            // Ownership + SRD flag
            $table->boolean('is_srd')->default(false);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('base_item_id');
            $table->dropColumn(['is_srd', 'user_id']);
        });
    }
};
