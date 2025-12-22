<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'numero', 'purchase_request_id', 'supplier_id', 'date_commande', 'date_livraison_prevue',
        'statut', 'montant_ht', 'tva', 'montant_ttc', 'mode_paiement', 'delai_paiement',
        'conditions_livraison', 'notes', 'attachments', 'project_id', 'department_id',
        'filiale_id', 'agence_id', 'created_by',
    ];

    protected $casts = [
        'date_commande' => 'date',
        'date_livraison_prevue' => 'date',
        'montant_ht' => 'decimal:2',
        'tva' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
        'attachments' => 'array',
    ];

    public function purchaseRequest() { return $this->belongsTo(PurchaseRequest::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function receptions() { return $this->hasMany(Reception::class); }
    
    public function scopeEnvoyee($query) { return $query->where('statut', 'envoyee'); }
    public function scopeLivree($query) { return $query->where('statut', 'livree'); }
}
