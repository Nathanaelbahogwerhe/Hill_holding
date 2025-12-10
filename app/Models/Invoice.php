<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'agency_id',
        'user_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'amount',
        'status',
    ];

    // Relation vers le client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relation vers l'agence associÃ©e Ã  la facture
    public function agence()
    {
        return $this->belongsTo(Agence::class, 'agency_id');
    }

    // Relation vers l'utilisateur qui a crÃ©Ã© la facture
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}



