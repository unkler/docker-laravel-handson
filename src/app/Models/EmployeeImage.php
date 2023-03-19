<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'employee_id',
        'is_active',
    ];
}
