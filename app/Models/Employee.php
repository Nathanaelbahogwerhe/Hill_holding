<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory, Notifiable, FileUploadTrait;

    protected $fillable = [
        "user_id",
        "first_name",
        "last_name",
        "email",
        "department_id",
        "filiale_id",
        "agency_id",
        "position_id",
        "basic_salary",
        "attachments",

        // Identity
        'date_of_birth',
        'place_of_birth',
        'nationality',
        'id_document_type',
        'id_document_number',
        'id_document_file',

        // Contact
        'address',
        'phone',
        'personal_email',
        'emergency_contact_name',
        'emergency_contact_phone',

        // Administrative & Banking
        'matricule',
        'inss_number',
        'nif',
        'rib',

        // Contractual
        'contract_type',
        'hire_date',
        'workplace',
        'qualifications',

        // Family & salary extras
        'marital_status',
        'children_count',
        'salary_allowances',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'basic_salary' => 'decimal:2',
        'salary_allowances' => 'decimal:2',
        'attachments' => 'array',
    ];

    // Relations
    public function user() { return $this->belongsTo(User::class); }
    public function department() { return $this->belongsTo(Department::class); }
    public function filiale() { return $this->belongsTo(Filiale::class); }
    public function agence() { return $this->belongsTo(Agence::class, 'agency_id'); }
    public function position() { return $this->belongsTo(Position::class, 'position_id'); }

    // Messaging
    public function messagesSent() { return $this->hasMany(Message::class, 'sender_id'); }
    public function messagesReceived() { return $this->hasMany(Message::class, 'recipient_id'); }

    // Payroll
    public function payrolls() { return $this->hasMany(Payroll::class); }

    // Leaves
    public function leaves() { return $this->hasMany(Leave::class); }
    public function leaveTypes() { return $this->hasManyThrough(LeaveType::class, Leave::class); }

    // Attendance
    public function attendances() { return $this->hasMany(Attendance::class); }

    // Contracts
    public function contracts() { return $this->hasMany(Contract::class); }

    // Employee Insurances
    public function insurances() { return $this->hasMany(EmployeeInsurance::class); }

    // Tasks & Projects
    public function tasks() { return $this->hasMany(Task::class, 'employee_id'); }
    public function projects() { return $this->belongsToMany(Project::class, 'employee_project')->withTimestamps(); }

    // Auto-generated email
    public function getGeneratedEmailAttribute()
    {
        if (!empty($this->first_name) && !empty($this->last_name)) {
            $username = strtolower($this->first_name . '.' . $this->last_name);
        } elseif (!empty($this->first_name)) {
            $username = strtolower($this->first_name);
        } elseif (!empty($this->last_name)) {
            $username = strtolower($this->last_name);
        } else {
            $username = 'employee' . $this->id;
        }

        if ($this->agence && $this->agence->filiale) {
            $domain = strtolower(str_replace(' ', '', $this->agence->filiale->name)) . '.com';
        } elseif ($this->filiale) {
            $domain = strtolower(str_replace(' ', '', $this->filiale->name)) . '.com';
        } else {
            $domain = 'novacore.com';
        }

        return $username . '@' . $domain;
    }

    public function getIdDocumentUrlAttribute()
    {
        if (!$this->id_document_file) return null;
        // use Storage::disk('local') since files stored privately
        return Storage::disk('local')->exists($this->id_document_file)
            ? route('employees.document', $this->id) : null;
    }
}