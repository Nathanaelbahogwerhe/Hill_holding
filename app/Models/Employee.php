<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'department_id',
        'filiale_id',
        'agency_id',
        'basic_salary',
    ];

    // ----------------- Relations de base -----------------
    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->belongsTo(Agence::class, 'agency_id');
    }

    // ----------------- Messagerie -----------------
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }

    // ----------------- Paie -----------------
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    // ----------------- CongÃ©s -----------------
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function leaveTypes()
    {
        return $this->hasManyThrough(LeaveType::class, Leave::class);
    }

    // ----------------- PrÃ©sences -----------------
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // ----------------- Contrats -----------------
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    // ----------------- Assurances -----------------
    public function insurances()
    {
        return $this->hasMany(Insurance::class);
    }

    // ----------------- Projets et tÃ¢ches -----------------
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'employee_project')
                    ->withTimestamps();
    }

    // ----------------- Email auto-gÃ©nÃ©rÃ© -----------------
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
            $domain = 'HillHolding.com';
        }

        return $username . '@' . $domain;
    }
}



