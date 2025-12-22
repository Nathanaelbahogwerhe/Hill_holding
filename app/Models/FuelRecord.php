<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelRecord extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'vehicle_id', 'mission_id', 'date_heure', 'type_carburant', 'quantite_litres',
        'prix_unitaire', 'montant_total', 'kilometrage', 'km_depuis_dernier_plein',
        'consommation_calculee', 'station_service', 'lieu', 'mode_paiement', 'numero_facture',
        'effectue_par', 'valide_par', 'valide', 'observations', 'attachments', 'filiale_id', 'agence_id',
    ];

    protected $casts = [
        'date_heure' => 'datetime',
        'quantite_litres' => 'decimal:2',
        'prix_unitaire' => 'decimal:2',
        'montant_total' => 'decimal:2',
        'consommation_calculee' => 'decimal:2',
        'valide' => 'boolean',
        'attachments' => 'array',
    ];

    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function mission() { return $this->belongsTo(Mission::class); }
    public function effectuePar() { return $this->belongsTo(User::class, 'effectue_par'); }
    public function filiale() { return $this->belongsTo(Filiale::class); }
    public function agence() { return $this->belongsTo(Agence::class); }
    
    public function scopeValide($query) { return $query->where('valide', true); }
    public function scopeThisMonth($query) {
        return $query->whereMonth('date_heure', now()->month)->whereYear('date_heure', now()->year);
    }
}
