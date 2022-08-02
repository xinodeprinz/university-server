<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'password'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'password'
    ];

    public function departments()
    {
        return $this->hasMany(Department::class, 'faculties_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
