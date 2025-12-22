<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        'titre',
        'description',
        'type',
        'date_prevue',
        'heure_debut',
        'heure_fin',
        'lieu',
        'statut',
        'participants',
        'project_id',
        'department_id',
        'filiale_id',
        'agence_id',
        'created_by',
        'responsible_id',
    ];

    protected $casts = [
        'date_prevue' => 'date',
        'participants' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'activity_participants', 'activity_id', 'user_id');
    }

    public function scopePlanifiee($query)
    {
        return $query->where('statut', 'planifiée');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date_prevue', today());
    }

    public function scopeUpcoming($query, $days = 7)
    {
        return $query->whereBetween('date_prevue', [today(), today()->addDays($days)]);
    }
}

