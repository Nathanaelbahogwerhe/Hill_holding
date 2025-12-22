<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breakdown extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'numero', 'equipment_id', 'date_panne', 'date_resolution', 'severite', 'statut', 'titre',
        'description', 'symptomes', 'cause_identifiee', 'declarant_id', 'impacte_production',
        'impact_description', 'technicien_assigne_id', 'date_intervention', 'actions_correctives',
        'pieces_remplacees', 'cout_reparation', 'cout_pieces', 'cout_total', 'duree_arret_minutes',
        'solution_appliquee', 'mesures_preventives', 'attachments', 'filiale_id', 'agence_id',
    ];

    protected $casts = [
        'date_panne' => 'datetime',
        'date_resolution' => 'datetime',
        'date_intervention' => 'datetime',
        'impacte_production' => 'boolean',
        'cout_reparation' => 'decimal:2',
        'cout_pieces' => 'decimal:2',
        'cout_total' => 'decimal:2',
        'attachments' => 'array',
    ];

    public function equipment() { return $this->belongsTo(Equipment::class); }
    public function declarant() { return $this->belongsTo(User::class, 'declarant_id'); }
    public function technicien() { return $this->belongsTo(User::class, 'technicien_assigne_id'); }
    public function filiale() { return $this->belongsTo(Filiale::class); }
    public function agence() { return $this->belongsTo(Agence::class); }
    
    public function scopeCritique($query) { return $query->where('severite', 'critique'); }
    public function scopeNonResolue($query) { return $query->whereIn('statut', ['declaree', 'en_diagnostic', 'en_reparation']); }
}
