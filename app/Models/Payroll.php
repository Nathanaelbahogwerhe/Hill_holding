<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = ['employee_id', 'pay_date', 'amount', 'status', 'month', 'base_salary', 'basic_salary', 'bonus', 'bonuses', 'allowances', 'deductions', 'net_salary', 'payment_date', 'attachments'];

    protected $casts = [
        'attachments' => 'array',
    ];

    // Une fiche de paie appartient à un employé
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}




