<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoaLevel400his extends Model
{
    use HasFactory;
    public $connection = 'mysql_courses';
    public $timestamps = false;

    protected $fillables = [
        'course_code',
        'course_title',
        'credit_value',
        'course_master',
    ];
}
