<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'immatriculation',
        'marque',
        'modele',
        'annee',
        'type',
        'couleur',
        'numero_chassis',
        'kilometrage',
        'proprietaire',
        'date_acquisition',
        'prix_acquisition',
        'assureur',
        'numero_police',
        'date_debut_assurance',
        'date_fin_assurance',
        'montant_assurance',
        'derniere_visite_technique',
        'prochaine_visite_technique',
        'etat',
        'statut',
        'chauffeur_attitule_id',
        'affecte_a_service',
        'derniere_maintenance',
        'prochaine_maintenance',
        'frequence_maintenance_km',
        'nombre_places',
        'capacite_charge_kg',
        'type_carburant',
        'consommation_moyenne',
        'attachments',
        'filiale_id',
        'agence_id',
    ];

    protected $casts = [
        'date_acquisition' => 'date',
        'date_debut_assurance' => 'date',
        'date_fin_assurance' => 'date',
        'derniere_visite_technique' => 'date',
        'prochaine_visite_technique' => 'date',
        'derniere_maintenance' => 'date',
        'prochaine_maintenance' => 'date',
        'prix_acquisition' => 'decimal:2',
        'montant_assurance' => 'decimal:2',
        'capacite_charge_kg' => 'decimal:2',
        'consommation_moyenne' => 'decimal:2',
        'attachments' => 'array',
    ];

    public function chauffeur()
    {
        return $this->belongsTo(User::class, 'chauffeur_attitule_id');
    }

    public function service()
    {
        return $this->belongsTo(Department::class, 'affecte_a_service');
    }

    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }

    public function fuelRecords()
    {
        return $this->hasMany(FuelRecord::class);
    }

    public function maintenances()
    {
        return $this->hasMany(VehicleMaintenance::class);
    }

    // Scopes
    public function scopeDisponible($query)
    {
        return $query->where('statut', 'disponible');
    }

    public function scopeEnMission($query)
    {
        return $query->where('statut', 'en_mission');
    }

    public function scopeAssuranceExpireeSoon($query, $days = 30)
    {
        return $query->whereBetween('date_fin_assurance', [now(), now()->addDays($days)]);
    }

    public function scopeVisiteTechniqueDue($query)
    {
        return $query->where('prochaine_visite_technique', '<=', now()->addDays(15));
    }

    // Attributs
    public function getIsAssuranceActiveAttribute()
    {
        return $this->date_fin_assurance && $this->date_fin_assurance >= now();
    }

    public function getVisiteTechniqueDueAttribute()
    {
        return $this->prochaine_visite_technique && $this->prochaine_visite_technique <= now();
    }

    public function getConsommationMoyenneRealAttribute()
    {
        $records = $this->fuelRecords()->whereNotNull('consommation_calculee')->get();
        return $records->avg('consommation_calculee');
    }
}
