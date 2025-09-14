<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Npc extends Model
{
    use HasFactory;

    // --- SRD Defaults ---
    public const ALIGNMENTS = [
        'Lawful Good', 'Neutral Good', 'Chaotic Good',
        'Lawful Neutral', 'True Neutral', 'Chaotic Neutral',
        'Lawful Evil', 'Neutral Evil', 'Chaotic Evil',
    ];

    public const RACES = [
        'Dragonborn', 'Dwarf', 'Elf', 'Gnome', 'Goliath', 'Halfling', 'Human', 'Orc', 'Tiefling',
    ];

    public const CLASSES = [
        'Barbarian', 'Bard', 'Cleric', 'Druid', 'Fighter', 'Monk', 'Paladin', 'Ranger', 'Rogue', 'Sorcerer', 'Warlock', 'Wizard',
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

    public const STATUSES = [
        'Alive', 'Deceased', 'Unknown',
    ];

    protected $fillable = [
        'campaign_id', 'name', 'alias', 'race', 'class', 'role', 'alignment', 'location', 'status', 'portrait_path',
        'description', 'personality', 'quirks',
        'strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma',
        'armor_class', 'hit_points', 'speed', 'challenge_rating', 'proficiency_bonus',
    ];

    // --- Option Accessors ---
    public static function raceOptions(): array
    {
        return self::RACES;
        // Later: return Race::pluck('name')->all();
    }

    public static function classOptions(): array
    {
        return self::CLASSES;
        // Later: return CharacterClass::pluck('name')->all();
    }

    public static function alignmentOptions(): array
    {
        return self::ALIGNMENTS;
        // Later: return Alignment::pluck('name')->all();
    }

    public static function socialRoleOptions(): array
    {
        return self::SOCIAL_ROLES;
        // Later: return SocialRole::pluck('name')->all();
    }

    public static function statusOptions(): array
    {
        return self::STATUSES;
    }
}
