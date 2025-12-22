<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItIntervention extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'numero',
        'filiale_id',
        'agence_id',
        'demandeur_id',
        'department_id',
        'it_equipment_id',
        'type',
        'priorite',
        'objet',
        'description',
        'technicien_id',
        'date_intervention',
        'diagnostic',
        'solution',
        'duree_heures',
        'statut',
        'date_resolution',
        'note_satisfaction',
        'commentaire_satisfaction',
        'remarques',
    ];

    protected $casts = [
        'date_intervention' => 'datetime',
        'date_resolution' => 'date',
        'duree_heures' => 'decimal:2',
        'note_satisfaction' => 'integer',
    ];

    // Relations
    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function demandeur()
    {
        return $this->belongsTo(User::class, 'demandeur_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    public function itEquipment()
    {
        return $this->belongsTo(ItEquipment::class);
    }

    // Scopes
    public function scopeOuverte($query)
    {
        return $query->where('statut', 'ouverte');
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeUrgente($query)
    {
        return $query->where('priorite', 'urgente');
    }

    // Attributs calculés
    public function getPrioriteColorAttribute()
    {
        return match($this->priorite) {
            'basse' => 'gray',
            'normale' => 'blue',
            'haute' => 'orange',
            'urgente' => 'red',
            default => 'gray',
        };
    }

    public function getStatutColorAttribute()
    {
        return match($this->statut) {
            'ouverte' => 'blue',
            'en_cours' => 'yellow',
            'en_attente' => 'orange',
            'resolue' => 'green',
            'fermee' => 'gray',
            default => 'gray',
        };
    }
}
