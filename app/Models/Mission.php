<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'numero', 'vehicle_id', 'chauffeur_id', 'objet', 'description', 'date_heure_depart',
        'date_heure_retour_prevue', 'date_heure_retour_reel', 'lieu_depart', 'lieu_destination',
        'itineraire', 'distance_km', 'statut', 'type', 'passagers', 'nombre_passagers',
        'km_depart', 'km_retour', 'km_parcourus', 'carburant_utilise_litres', 'cout_carburant',
        'frais_peage', 'autres_frais', 'cout_total', 'details_frais', 'observations', 'incidents',
        'mission_reussie', 'attachments', 'autorise_par', 'valide_par', 'project_id',
        'department_id', 'filiale_id', 'agence_id', 'created_by',
    ];

    protected $casts = [
        'date_heure_depart' => 'datetime',
        'date_heure_retour_prevue' => 'datetime',
        'date_heure_retour_reel' => 'datetime',
        'distance_km' => 'decimal:2',
        'carburant_utilise_litres' => 'decimal:2',
        'cout_carburant' => 'decimal:2',
        'frais_peage' => 'decimal:2',
        'autres_frais' => 'decimal:2',
        'cout_total' => 'decimal:2',
        'mission_reussie' => 'boolean',
        'passagers' => 'array',
        'attachments' => 'array',
    ];

    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function chauffeur() { return $this->belongsTo(User::class, 'chauffeur_id'); }
    public function fuelRecords() { return $this->hasMany(FuelRecord::class); }
    public function filiale() { return $this->belongsTo(Filiale::class); }
    public function agence() { return $this->belongsTo(Agence::class); }
    
    public function scopeEnCours($query) { return $query->where('statut', 'en_cours'); }
    public function scopeTerminee($query) { return $query->where('statut', 'terminee'); }
}
