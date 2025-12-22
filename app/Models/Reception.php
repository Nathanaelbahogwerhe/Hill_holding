<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'numero', 'purchase_order_id', 'date_reception', 'heure_reception', 'receptionnaire',
        'statut', 'articles_recus', 'reserves', 'conforme', 'non_conformites', 'actions_requises',
        'attachments', 'filiale_id', 'agence_id', 'created_by',
    ];

    protected $casts = [
        'date_reception' => 'date',
        'conforme' => 'boolean',
        'attachments' => 'array',
    ];

    public function purchaseOrder() { return $this->belongsTo(PurchaseOrder::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function filiale() { return $this->belongsTo(Filiale::class); }
    public function agence() { return $this->belongsTo(Agence::class); }
    
    public function scopeConforme($query) { return $query->where('conforme', true); }
    public function scopeAvecReserves($query) { return $query->where('statut', 'avec_reserves'); }
}
