<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';

    protected $fillable = [
        'student_id',
        'payment_period_id',
        'total_amount',
    ];
}
