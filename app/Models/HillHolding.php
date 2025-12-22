<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HillHolding extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
    ];

    // HillHolding est la maison mere et a plusieurs filiales
    public function filiales()
    {
        return $this->hasMany(Filiale::class);
    }
}