<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'responsible_id',  // Ajouté pour la relation responsable
        'start_date',
        'due_date',
        'details',
    ];

    // 🔗 Un projet a plusieurs tâches
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // 🔗 Relation vers l'utilisateur responsable
    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_project')->withTimestamps();
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

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function dailyOperations()
    {
        return $this->hasMany(DailyOperation::class);
    }
}




