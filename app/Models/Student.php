<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';
    protected $fillable = [
        'institution_id',
        'student_id',
        'name',
        'gender',
        'year',
        'phone',
        'email',
        'balance',
        'password',
        'major',
        'is_deleted',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
