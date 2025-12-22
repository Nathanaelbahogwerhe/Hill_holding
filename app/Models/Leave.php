<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = ['employee_id', 'leave_type_id', 'start_date', 'end_date', 'status', 'attachments'];

    // Casts pour que les dates soient des objets Carbon
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'attachments' => 'array',
    ];

    // Un congé appartient à un employé
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Un congé appartient à un type de congé
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
