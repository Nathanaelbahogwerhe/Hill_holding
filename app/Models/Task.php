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
        'assigned_to',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    // ðŸ”— Une tÃ¢che appartient Ã  un projet
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // ðŸ”— Une tÃ¢che est assignÃ©e Ã  un employÃ©
    public function assignedTo()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}







