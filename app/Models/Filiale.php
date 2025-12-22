<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiale extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'code',
        'location',
        'hill_holding_id'
    ];

    // Relation vers la maison mère (HillHolding)
    public function hillHolding()
    {
        return $this->belongsTo(HillHolding::class, 'hill_holding_id');
    }

    public function agences()
    {
        return $this->hasMany(Agence::class);
    }

    public function employees() {
        return $this->hasMany(Employee::class); // Relation directe
    }

    public function employeesViaAgences() {
        return $this->hasManyThrough(Employee::class, Agence::class); // Garder pour accès spécifique
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
