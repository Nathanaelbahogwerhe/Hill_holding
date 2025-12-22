<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'amount',
        'payment_date',
        'method', // ou autres colonnes
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
