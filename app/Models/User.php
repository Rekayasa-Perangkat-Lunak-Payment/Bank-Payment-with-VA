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

    protected $fillable = [
        'username',
        'email',
        'password',
        'is_deleted',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function bankAdmin()
    {
        return $this->hasOne(BankAdmin::class);
    }

    public function institutionAdmin()
    {
        return $this->hasOne(InstitutionAdmin::class);
    }

    public function getRoleAttribute()
    {
        if ($this->adminBank) {
            return 'bank_admin';
        }
        if ($this->institutionAdmin) {
            return 'institution_admin';
        }
        return 'user'; // Default role or fallback
    }
}
