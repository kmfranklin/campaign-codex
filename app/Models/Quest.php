<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $fillable = ['campaign_id', 'name', 'description', 'status'];

    public function campaign()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_quest')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function npcs()
    {
        return $this->belongsToMany(Npc::class, 'quest_npc')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
