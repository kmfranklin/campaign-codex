<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    protected $fillable = ['campaign_id', 'name', 'description', 'status'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function npcs()
    {
        return $this->belongsToMany(Npc::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
