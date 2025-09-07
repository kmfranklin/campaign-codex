<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('npcs', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->unsignedBigInteger('campaign_id')->nullable();

            // Core identity
            $table->string('name');
            $table->string('alias')->nullable();
            $table->string('race')->nullable();
            $table->string('class')->nullable();
            $table->string('role')->nullable(); // narrative role (shopkeep, militia, etc.)
            $table->string('alignment')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('Alive'); // Alive, Deceased, Missing, Unknown
            $table->string('portrait_path')->nullable();

            // Descriptive fields
            $table->text('description')->nullable();
            $table->text('personality')->nullable();
            $table->text('quirks')->nullable();

            // Abilities + combat stats
            $table->unsignedTinyInteger('strength')->nullable();
            $table->unsignedTinyInteger('dexterity')->nullable();
            $table->unsignedTinyInteger('constitution')->nullable();
            $table->unsignedTinyInteger('intelligence')->nullable();
            $table->unsignedTinyInteger('wisdom')->nullable();
            $table->unsignedTinyInteger('charisma')->nullable();

            $table->unsignedTinyInteger('armor_class')->nullable();
            $table->unsignedSmallInteger('hit_points')->nullable();
            $table->string('speed')->nullable();
            $table->string('challenge_rating')->nullable();
            $table->tinyInteger('proficiency_bonus')->nullable();

            // Flexible JSON fields for abilities/skills/saves
            $table->json('abilities_json')->nullable();       // special abilities, actions, traits
            $table->json('saving_throws_json')->nullable();   // overrides for saves
            $table->json('skills_json')->nullable();          // skill proficiencies

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('npcs');
    }
};
