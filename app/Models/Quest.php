<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'title',
        'description',
        'status',
    ];

    /**
     * Each quest belongs to one campaign.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Placeholder for future NPC relationships.
     */
    public function npcs()
    {
        return $this->belongsToMany(Npc::class, 'quest_npc')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * Placeholder for future encounters.
     * Each quest will eventually have many encounters.
     */
    public function encounters()
    {
        return $this->hasMany(Encounter::class);
    }
}
