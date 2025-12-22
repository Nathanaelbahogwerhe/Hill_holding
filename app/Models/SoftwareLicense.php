<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareLicense extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'numero',
        'filiale_id',
        'nom_logiciel',
        'editeur',
        'version',
        'type',
        'numero_licence',
        'cle_activation',
        'type_licence',
        'nombre_postes',
        'postes_utilises',
        'date_achat',
        'date_expiration',
        'cout',
        'periode_facturation',
        'statut',
        'supplier_id',
        'remarques',
    ];

    protected $casts = [
        'date_achat' => 'date',
        'date_expiration' => 'date',
        'cout' => 'decimal:2',
        'nombre_postes' => 'integer',
        'postes_utilises' => 'integer',
    ];

    // Relations
    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('statut', 'active');
    }

    public function scopeExpireeSoon($query, $days = 30)
    {
        return $query->where('statut', 'active')
                     ->whereNotNull('date_expiration')
                     ->whereBetween('date_expiration', [now(), now()->addDays($days)]);
    }

    public function scopeExpiree($query)
    {
        return $query->where('date_expiration', '<', now());
    }

    // Attributs calculés
    public function getIsActiveAttribute()
    {
        return $this->statut === 'active' && 
               (!$this->date_expiration || $this->date_expiration >= now());
    }

    public function getPostesDisponiblesAttribute()
    {
        return max(0, $this->nombre_postes - $this->postes_utilises);
    }

    public function getStatutColorAttribute()
    {
        return match($this->statut) {
            'active' => 'green',
            'expiree' => 'red',
            'resiliee' => 'gray',
            default => 'gray',
        };
    }

    public function getJoursRestantsAttribute()
    {
        if (!$this->date_expiration) return null;
        return now()->diffInDays($this->date_expiration, false);
    }
}
