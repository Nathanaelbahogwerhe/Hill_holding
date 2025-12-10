<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'description',
        'amount',
        'date',
        'status',
        'filiale_id',
        'agence_id',
    ];

    public function filiale() {
        return $this->belongsTo(Filiale::class);
    }

    public function agence() {
        return $this->belongsTo(Agence::class);
    }
}







