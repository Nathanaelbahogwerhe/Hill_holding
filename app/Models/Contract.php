<?php

namespace App\Models;

use App\Traits\FileUploadTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory, FileUploadTrait;

    protected $fillable = [
        "employee_id",
        "type",
        "contract_type",
        "start_date",
        "end_date",
        "salary",
        "details",
        "description",
        "attachments",
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}