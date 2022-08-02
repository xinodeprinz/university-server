<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_semester',
        'current_academic_year',
        'data'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
