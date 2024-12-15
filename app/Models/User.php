<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'username',
        'email',
        'password',
        'is_deleted',
    ];

    // Mutator for password hashing
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Relationship with BankAdmin
    public function bankAdmin()
    {
        return $this->hasOne(BankAdmin::class);
    }

    // Relationship with InstitutionAdmin
    public function institutionAdmin()
    {
        return $this->hasOne(InstitutionAdmin::class);
    }

    // Determine the role based on the relationships
    public function getRoleAttribute()
    {
        if ($this->bankAdmin) {
            return 'bank_admin';
        }

        if ($this->institutionAdmin) {
            return 'institution_admin';
        }

        return 'user'; // Default role if no admin roles are present
    }
}
