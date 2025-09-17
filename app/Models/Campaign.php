<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['name', 'description', 'dm_id'];

    // Owner DM (explicit FK)
    public function dm()
    {
        return $this->belongsTo(User::class, 'dm_id');
    }

    // All members (DM + players) via pivot
    public function members()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // Filtered members
    public function players()
    {
        return $this->members()->wherePivot('role', 'player');
    }

    public function dms()
    {
        return $this->members()->wherePivot('role', 'dm');
    }

    // Quests in this campaign
    public function quests()
    {
        return $this->hasMany(Quest::class);
    }

    // Campaign‑wide NPCs
    public function npcs()
    {
        return $this->hasMany(Npc::class);
    }
}
