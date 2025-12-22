<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory, FileUploadTrait;

    protected $table = 'equipment';

    protected $fillable = [
        'code',
        'nom',
        'type',
        'categorie',
        'description',
        'marque',
        'modele',
        'numero_serie',
        'date_acquisition',
        'prix_acquisition',
        'supplier_id',
        'numero_facture',
        'date_fin_garantie',
        'duree_garantie_mois',
        'etat',
        'statut',
        'localisation',
        'affecte_a',
        'date_affectation',
        'derniere_maintenance',
        'prochaine_maintenance',
        'frequence_maintenance_jours',
        'attachments',
        'department_id',
        'filiale_id',
        'agence_id',
    ];

    protected $casts = [
        'date_acquisition' => 'date',
        'date_fin_garantie' => 'date',
        'date_affectation' => 'date',
        'derniere_maintenance' => 'date',
        'prochaine_maintenance' => 'date',
        'prix_acquisition' => 'decimal:2',
        'attachments' => 'array',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function affectation()
    {
        return $this->belongsTo(User::class, 'affecte_a');
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

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function breakdowns()
    {
        return $this->hasMany(Breakdown::class);
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

    // Scopes
    public function scopeDisponible($query)
    {
        return $query->where('statut', 'disponible');
    }

    public function scopeEnService($query)
    {
        return $query->where('statut', 'en_service');
    }

    public function scopeMaintenanceDue($query)
    {
        return $query->where('prochaine_maintenance', '<=', now()->addDays(7));
    }

    public function scopeGarantiActive($query)
    {
        return $query->where('date_fin_garantie', '>=', now());
    }

    // Attributs
    public function getIsGarantieActiveAttribute()
    {
        return $this->date_fin_garantie && $this->date_fin_garantie >= now();
    }

    public function getMaintenanceDueAttribute()
    {
        return $this->prochaine_maintenance && $this->prochaine_maintenance <= now();
    }

    public function getEtatColorAttribute()
    {
        return match($this->etat) {
            'neuf' => 'green',
            'bon' => 'blue',
            'moyen' => 'yellow',
            'mauvais' => 'orange',
            'hors_service' => 'red',
        };
    }
}
