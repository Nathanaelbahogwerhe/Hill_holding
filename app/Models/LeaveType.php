<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'days', 'duration', 'attachment'];

    // Un type de congé peut être attribué à plusieurs congés
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}




