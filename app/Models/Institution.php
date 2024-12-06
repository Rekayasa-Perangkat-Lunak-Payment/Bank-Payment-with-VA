<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;
    protected $table = 'institutions';

    protected $fillable = [
        'npsn',
        'name',
        'status',
        'educational_level',
        'address',
        'phone',
        'email',
        'account_number',
    ];

    public function admins()
    {
        return $this->hasMany(InstitutionAdmin::class, 'institution_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'institution_id', 'id');
    }
}
