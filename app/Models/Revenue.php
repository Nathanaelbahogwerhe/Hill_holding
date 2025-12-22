<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'date',
        'filiale_id',
        'agence_id',
        'attachment',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function filiale() {
        return $this->belongsTo(Filiale::class);
    }

    public function agence() {
        return $this->belongsTo(Agence::class);
    }
}




