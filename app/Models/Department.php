<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // ðŸ”¹ Colonnes autorisÃ©es Ã  l'assignation de masse
    protected $fillable = [
        'name',
        'filiale_id',
        'agency_id', // Assure-toi que la colonne existe dans la table
    ];

    /**
     * Relation avec la filiale
     */
    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    /**
     * Relation avec l'agence
     * On garde le nom "agence" pour correspondre Ã  tes vues actuelles
     */
    public function agence()
    {
        return $this->belongsTo(Agence::class, 'agency_id');
    }

    /**
     * Relation avec les employÃ©s
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}







