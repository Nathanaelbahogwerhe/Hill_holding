<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsurancePlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'coverage_amount'];

    // Un plan d'assurance peut Ãªtre attribuÃ© Ã  plusieurs employÃ©s
    public function employeeInsurances()
    {
        return $this->hasMany(EmployeeInsurance::class);
    }
}







