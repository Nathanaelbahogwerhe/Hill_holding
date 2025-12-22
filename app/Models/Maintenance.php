<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'numero', 'equipment_id', 'type', 'priorite', 'titre', 'description', 'date_prevue',
        'date_realisation', 'heure_debut', 'heure_fin', 'statut', 'technicien_id',
        'travaux_realises', 'pieces_remplacees', 'cout_main_oeuvre', 'cout_pieces', 'cout_total',
        'reussite', 'observations', 'prochaine_maintenance', 'attachments', 'filiale_id', 'agence_id', 'created_by',
    ];

    protected $casts = [
        'date_prevue' => 'date',
        'date_realisation' => 'date',
        'cout_main_oeuvre' => 'decimal:2',
        'cout_pieces' => 'decimal:2',
        'cout_total' => 'decimal:2',
        'reussite' => 'boolean',
        'attachments' => 'array',
    ];

    public function equipment() { return $this->belongsTo(Equipment::class); }
    public function technicien() { return $this->belongsTo(User::class, 'technicien_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function filiale() { return $this->belongsTo(Filiale::class); }
    public function agence() { return $this->belongsTo(Agence::class); }
    
    public function scopePreventive($query) { return $query->where('type', 'preventive'); }
    public function scopeCorrective($query) { return $query->where('type', 'corrective'); }
    public function scopePlanifiee($query) { return $query->where('statut', 'planifiee'); }
}
