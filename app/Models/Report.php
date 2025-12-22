<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'titre',
        'type', // journalier, hebdomadaire, mensuel, projet, mission, département
        'contenu',
        'date_debut',
        'date_fin',
        'statut', // brouillon, soumis, validé, rejeté
        'soumis_par',
        'valide_par',
        'date_soumission',
        'date_validation',
        'commentaires',
        'attachments',
        'project_id',
        'department_id',
        'filiale_id',
        'agence_id',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_soumission' => 'datetime',
        'date_validation' => 'datetime',
    ];

    /**
     * Relation vers l'utilisateur qui a soumis
     */
    public function soumetteur()
    {
        return $this->belongsTo(User::class, 'soumis_par');
    }

    /**
     * Relation vers l'utilisateur qui a validé
     */
    public function validateur()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    /**
     * Relation vers le projet
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relation vers le département
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Relation vers la filiale
     */
    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    /**
     * Relation vers l'agence
     */
    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    /**
     * Scopes
     */
    public function scopeBrouillon($query)
    {
        return $query->where('statut', 'brouillon');
    }

    public function scopeSoumis($query)
    {
        return $query->where('statut', 'soumis');
    }

    public function scopeValide($query)
    {
        return $query->where('statut', 'validé');
    }

    public function scopeRejete($query)
    {
        return $query->where('statut', 'rejeté');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Attributs calculés
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->statut) {
            'brouillon' => '<span class="bg-gray-600 text-white px-2 py-1 rounded text-xs">Brouillon</span>',
            'soumis' => '<span class="bg-blue-600 text-white px-2 py-1 rounded text-xs">Soumis</span>',
            'validé' => '<span class="bg-green-600 text-white px-2 py-1 rounded text-xs">✓ Validé</span>',
            'rejeté' => '<span class="bg-red-600 text-white px-2 py-1 rounded text-xs">✗ Rejeté</span>',
            default => '<span class="bg-gray-500 text-white px-2 py-1 rounded text-xs">' . $this->statut . '</span>',
        };
    }

    public function getTypeBadgeAttribute()
    {
        return match($this->type) {
            'journalier' => '<span class="bg-purple-600 text-white px-2 py-1 rounded text-xs">📅 Journalier</span>',
            'hebdomadaire' => '<span class="bg-indigo-600 text-white px-2 py-1 rounded text-xs">📊 Hebdomadaire</span>',
            'mensuel' => '<span class="bg-blue-600 text-white px-2 py-1 rounded text-xs">📈 Mensuel</span>',
            'projet' => '<span class="bg-green-600 text-white px-2 py-1 rounded text-xs">🎯 Projet</span>',
            'mission' => '<span class="bg-orange-600 text-white px-2 py-1 rounded text-xs">🚀 Mission</span>',
            'département' => '<span class="bg-yellow-600 text-black px-2 py-1 rounded text-xs">🏢 Département</span>',
            default => '<span class="bg-gray-600 text-white px-2 py-1 rounded text-xs">' . $this->type . '</span>',
        };
    }
}
