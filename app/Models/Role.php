<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const DM        = 1;
    const PLAYER    = 2;

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'campaign_user')
                    ->withPivot('campaign_id')
                    ->withTimestamps();
    }

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaign_user')
                    ->withPivot('user_id')
                    ->withTimestamps();
    }
}
