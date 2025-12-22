<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMaintenance extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'numero', 'vehicle_id', 'type', 'priorite', 'titre', 'description', 'date_prevue',
        'date_realisation', 'kilometrage_au_moment', 'statut', 'lieu', 'nom_prestataire',
        'supplier_id', 'travaux_realises', 'pieces_remplacees', 'observations',
        'cout_main_oeuvre', 'cout_pieces', 'autres_frais', 'cout_total',
        'km_prochaine_maintenance', 'date_prochaine_maintenance', 'attachments',
        'responsable_id', 'valide_par', 'filiale_id', 'agence_id', 'created_by',
    ];

    protected $casts = [
        'date_prevue' => 'date',
        'date_realisation' => 'date',
        'date_prochaine_maintenance' => 'date',
        'cout_main_oeuvre' => 'decimal:2',
        'cout_pieces' => 'decimal:2',
        'autres_frais' => 'decimal:2',
        'cout_total' => 'decimal:2',
        'attachments' => 'array',
    ];

    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function responsable() { return $this->belongsTo(User::class, 'responsable_id'); }
    public function filiale() { return $this->belongsTo(Filiale::class); }
    public function agence() { return $this->belongsTo(Agence::class); }
    
    public function scopePlanifiee($query) { return $query->where('statut', 'planifiee'); }
    public function scopeTerminee($query) { return $query->where('statut', 'terminee'); }
}
