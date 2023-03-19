<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkplaceImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'workplace_id',
        'is_active',
    ];
}
