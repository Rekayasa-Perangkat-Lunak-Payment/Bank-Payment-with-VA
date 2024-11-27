<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
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
}
