<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_key',
        'name',
        'description',
        'cost',
        'weight',
        'is_magic_item',
        'requires_attunement',
        'attunement_requirements',
        'item_category_id',
        'item_rarity_id',
    ];

    // Relationships
    public function weapon()
    {
        return $this->hasOne(Weapon::class);
    }

    public function armor()
    {
        return $this->hasOne(Armor::class);
    }

    public function category()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }

    public function rarity()
    {
        return $this->belongsTo(ItemRarity::class, 'item_rarity_id');
    }
}
