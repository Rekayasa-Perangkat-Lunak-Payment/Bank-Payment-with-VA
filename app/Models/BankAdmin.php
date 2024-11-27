<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAdmin extends Model
{
    use HasFactory;
    protected $table = 'bank_admins';

    protected $fillable = [
        'user_id',
        'name',
        'nik',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
