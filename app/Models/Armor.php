<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Armor extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'base_ac',
        'adds_dex_mod',
        'dex_mod_cap',
        'imposes_stealth_disadvantage',
        'strength_requirement',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
