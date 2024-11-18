<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function bankAdmin()
    {
        return $this->hasOne(BankAdmin::class); // One-to-one relation with bank_admin table
    }

    public function institutionAdmin()
    {
        return $this->hasOne(InstitutionAdmin::class); // One-to-one relation with institution_admin table
    }
}
