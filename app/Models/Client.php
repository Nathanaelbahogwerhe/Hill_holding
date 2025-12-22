<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'filiale_id',
        'agence_id',
        'total_due',
        'total_paid',
        'balance',
        'status',
    ];

    // Relation vers la filiale
    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    // Relation vers l'agence
    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    // 🔗 Relation vers les factures
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // Calculer le solde restant
    public function calculateBalance()
    {
        $this->balance = $this->total_due - $this->total_paid;
        return $this->balance;
    }

    // Vérifier si le client est à jour de ses paiements
    public function isPaidUp()
    {
        return $this->balance <= 0;
    }
}
