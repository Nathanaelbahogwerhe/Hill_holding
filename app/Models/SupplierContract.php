<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierContract extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'reference', 'supplier_id', 'titre', 'type', 'description', 'date_debut', 'date_fin',
        'statut', 'montant_annuel', 'montant_total', 'devise', 'conditions_paiement',
        'conditions_livraison', 'clauses_particulieres', 'delai_preavis_jours', 'renouvelable',
        'type_renouvellement', 'date_prochain_renouvellement', 'responsable_interne_id',
        'contact_fournisseur', 'attachments', 'department_id', 'filiale_id', 'created_by',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_prochain_renouvellement' => 'date',
        'montant_annuel' => 'decimal:2',
        'montant_total' => 'decimal:2',
        'renouvelable' => 'boolean',
        'attachments' => 'array',
    ];

    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function responsable() { return $this->belongsTo(User::class, 'responsable_interne_id'); }
    public function filiale() { return $this->belongsTo(Filiale::class); }
    public function agence() { return $this->belongsTo(Agence::class); }
    
    public function scopeActif($query) { return $query->where('statut', 'actif'); }
    public function scopeExpireSoon($query, $days = 30) {
        return $query->whereBetween('date_fin', [now(), now()->addDays($days)]);
    }
}
