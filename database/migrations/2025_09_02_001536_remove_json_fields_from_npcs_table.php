<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('npcs', function (Blueprint $table) {
        $table->dropColumn(['abilities_json', 'saving_throws_json', 'skills_json']);
    });
}

public function down()
{
    Schema::table('npcs', function (Blueprint $table) {
        $table->json('abilities_json')->nullable();
        $table->json('saving_throws_json')->nullable();
        $table->json('skills_json')->nullable();
    });
}
};
