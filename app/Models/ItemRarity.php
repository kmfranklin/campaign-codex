<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemRarity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
