<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Npc extends Model
{
    use HasFactory;

    public const ALIGNMENTS = [
        'Lawful Good', 'Neutral Good', 'Chaotic Good',
        'Lawful Neutral', 'True Neutral', 'Chaotic Neutral',
        'Lawful Evil', 'Neutral Evil', 'Chaotic Evil',
    ];

    public const CLASSES = [
        'Artificer', 'Barbarian', 'Bard', 'Cleric', 'Druid', 'Fighter', 'Monk', 'Ranger', 'Rogue', 'Sorcerer', 'Warlock', 'Wizard',
    ];

    public const SOCIAL_ROLES = [
        'Ally', 'Enemy', 'Neutral',
    ];

    public const NARRATIVE_ROLES = [
        'Quest Giver', 'Merchant', 'Trainer/Mentor', 'Informant', 'Guide',
    ];

    public const ARCHETYPE_ROLES = [
        'Faction Leader', 'Civilian', 'Villain', 'Patron', 'Companion', 'Rival',
    ];

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
