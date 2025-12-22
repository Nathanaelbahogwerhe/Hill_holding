<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'numero', 'equipment_id', 'maintenance_id', 'breakdown_id', 'type', 'titre', 'description',
        'date_heure_debut', 'date_heure_fin', 'duree_minutes', 'statut', 'technicien_principal_id',
        'techniciens_secondaires', 'travaux_effectues', 'outils_utilises', 'pieces_utilisees',
        'resultat', 'observations', 'recommandations', 'valide_par', 'date_validation',
        'attachments', 'filiale_id', 'agence_id', 'created_by',
    ];

    protected $casts = [
        'date_heure_debut' => 'datetime',
        'date_heure_fin' => 'datetime',
        'date_validation' => 'datetime',
        'techniciens_secondaires' => 'array',
        'attachments' => 'array',
    ];

    public function equipment() { return $this->belongsTo(Equipment::class); }
    public function maintenance() { return $this->belongsTo(Maintenance::class); }
    public function breakdown() { return $this->belongsTo(Breakdown::class); }
    public function technicienPrincipal() { return $this->belongsTo(User::class, 'technicien_principal_id'); }
    public function filiale() { return $this->belongsTo(Filiale::class); }
    public function agence() { return $this->belongsTo(Agence::class); }
    
    public function scopeEnCours($query) { return $query->where('statut', 'en_cours'); }
}
