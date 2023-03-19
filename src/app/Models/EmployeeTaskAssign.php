<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeTaskAssign extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'employee_task_assign';

    protected $fillable = [
        'employee_id',
        'task_assign_id',
    ];
}
