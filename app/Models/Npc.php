<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Npc extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        // Core identity
        'campaign_id',
        'name',
        'alias',
        'race',
        'class',
        'role',
        'alignment',
        'location',
        'status',
        'portrait_path',

        // Descriptive
        'description',
        'personality',
        'quirks',

        // Abilities + stats
        'strength',
        'dexterity',
        'constitution',
        'intelligence',
        'wisdom',
        'charisma',
        'armor_class',
        'hit_points',
        'speed',
        'challenge_rating',
        'proficiency_bonus',
    ];

    /**
     * Relationships
     */
    // public function campaign()
    // {
    //     return $this->belongsTo(Campaign::class);
    // }
}
