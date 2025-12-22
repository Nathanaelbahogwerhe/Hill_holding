<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'project_id',
        'employee_id', // <- remplacé assigned_to
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    // 🔗 Une tâche appartient à un projet
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // 🔗 Une tâche est assignée à un employé
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function filiale()
    {
        return $this->belongsTo(Filiale::class);
    }

    public function agence()
    {
        return $this->belongsTo(Agence::class);
    }

    public function evaluations()
    {
        return $this->morphMany(Evaluation::class, 'evaluable');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'En cours');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Terminée');
    }
}
