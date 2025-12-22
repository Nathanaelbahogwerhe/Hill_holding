<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'numero',
        'titre',
        'description',
        'type',
        'priorite',
        'statut',
        'montant_estime',
        'date_besoin',
        'justification',
        'demandeur_id',
        'approbateur_id',
        'date_approbation',
        'commentaire_approbation',
        'project_id',
        'department_id',
        'filiale_id',
        'agence_id',
    ];

    protected $casts = [
        'date_besoin' => 'date',
        'date_approbation' => 'datetime',
        'montant_estime' => 'decimal:2',
    ];

    public function demandeur()
    {
        return $this->belongsTo(User::class, 'demandeur_id');
    }

    public function approbateur()
    {
        return $this->belongsTo(User::class, 'approbateur_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    // Scopes
    public function scopeBrouillon($query)
    {
        return $query->where('statut', 'brouillon');
    }

    public function scopeSoumise($query)
    {
        return $query->where('statut', 'soumise');
    }

    public function scopeApprouvee($query)
    {
        return $query->where('statut', 'approuvee');
    }

    public function scopeUrgente($query)
    {
        return $query->where('priorite', 'urgente');
    }

    public function scopeEnAttente($query)
    {
        return $query->whereIn('statut', ['soumise', 'approuvee']);
    }

    // Méthodes métier
    public function approuver(User $approbateur, $commentaire = null)
    {
        $this->statut = 'approuvee';
        $this->approbateur_id = $approbateur->id;
        $this->date_approbation = now();
        $this->commentaire_approbation = $commentaire;
        $this->save();
    }

    public function rejeter(User $approbateur, $commentaire)
    {
        $this->statut = 'rejetee';
        $this->approbateur_id = $approbateur->id;
        $this->date_approbation = now();
        $this->commentaire_approbation = $commentaire;
        $this->save();
    }

    public function getPrioriteColorAttribute()
    {
        return match($this->priorite) {
            'urgente' => 'red',
            'haute' => 'orange',
            'normale' => 'blue',
            'basse' => 'gray',
        };
    }
}
