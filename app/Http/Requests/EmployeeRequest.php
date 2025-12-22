<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() !== null;
    }

    public function rules()
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',

            // Identity
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'id_document_type' => 'nullable|string|max:100',
            'id_document_number' => 'nullable|string|max:255',
            'id_document_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Contact
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'personal_email' => 'nullable|email|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:50',

            // Administrative & bank
            'matricule' => 'nullable|string|max:100',
            'inss_number' => 'nullable|string|max:100',
            'nif' => 'nullable|string|max:100',
            'rib' => 'nullable|string|max:255',

            // Contractual
            'contract_type' => 'nullable|string|max:50',
            'hire_date' => 'nullable|date',
            'workplace' => 'nullable|string|max:255',
            'qualifications' => 'nullable|string',

            // Family & salary
            'marital_status' => 'nullable|string|max:50',
            'children_count' => 'nullable|integer|min:0',
            'salary_allowances' => 'nullable|numeric',

            // existing
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'filiale_id' => 'nullable|exists:filiales,id',
            'agency_id' => 'nullable|exists:agences,id',
            'basic_salary' => 'nullable|numeric|min:0',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ];
    }
}
