<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;

class EmployeePolicy
{
    /**
     * Determine whether the user can view the employee.
     */
    public function view(User $user, Employee $employee): bool
    {
        if ($user->hasRole(['Super Admin', 'RH Manager'])) {
            return true;
        }

        if ($employee->user_id && $user->id === $employee->user_id) {
            return true;
        }

        // Filiale/agency scoping
        if ($user->filiale_id && $user->filiale_id === $employee->filiale_id) return true;
        if ($user->agency_id && $user->agency_id === $employee->agence_id) return true;

        return false;
    }

    /**
     * Determine whether the user can download the employee document.
     */
    public function downloadDocument(User $user, Employee $employee): bool
    {
        // same rules as view, stricter could be applied here
        return $this->view($user, $employee);
    }
}
