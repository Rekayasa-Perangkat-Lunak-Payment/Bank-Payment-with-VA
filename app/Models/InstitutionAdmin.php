<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionAdmin extends Model
{
    use HasFactory;
    protected $table = 'institution_admins';
    protected $fillable = [
        'user_id',
        'institution_id',
        'name',
        'title',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
