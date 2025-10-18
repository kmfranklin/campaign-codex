<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DamageType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }
}
