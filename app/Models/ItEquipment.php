<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItEquipment extends Model
{
    use HasFactory, FileUploadTrait;

    protected $table = 'it_equipment';

    protected $fillable = [
        'numero',
        'filiale_id',
        'agence_id',
        'department_id',
        'type',
        'marque',
        'modele',
        'numero_serie',
        'processeur',
        'ram',
        'disque_dur',
        'systeme_exploitation',
        'utilisateur_id',
        'date_attribution',
        'localisation',
        'date_acquisition',
        'prix_acquisition',
        'supplier_id',
        'date_fin_garantie',
        'statut',
        'etat',
        'configuration_details',
        'remarques',
    ];

    protected $casts = [
        'date_attribution' => 'date',
        'date_acquisition' => 'date',
        'date_fin_garantie' => 'date',
        'prix_acquisition' => 'decimal:2',
    ];

    // Relations
    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function interventions()
    {
        return $this->hasMany(ItIntervention::class);
    }

    // Scopes
    public function scopeEnService($query)
    {
        return $query->where('statut', 'en_service');
    }

    public function scopeDisponible($query)
    {
        return $query->where('statut', 'disponible');
    }

    public function scopeGarantieActive($query)
    {
        return $query->whereNotNull('date_fin_garantie')
                     ->where('date_fin_garantie', '>=', now());
    }

    // Attributs calculés
    public function getIsGarantieActiveAttribute()
    {
        return $this->date_fin_garantie && $this->date_fin_garantie >= now();
    }

    public function getTypeDisplayAttribute()
    {
        return ucfirst($this->type);
    }

    public function getStatutColorAttribute()
    {
        return match($this->statut) {
            'disponible' => 'green',
            'en_service' => 'blue',
            'en_reparation' => 'yellow',
            'hors_service' => 'red',
            'reforme' => 'gray',
            default => 'gray',
        };
    }
}
