<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'damage_dice',
        'damage_type_id',
        'weapon_category',
        'weapon_range',
        'range_normal',
        'range_long',
        'properties',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function damageType()
    {
        return $this->belongsTo(DamageType::class);
    }
}
