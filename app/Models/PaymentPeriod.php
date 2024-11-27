<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPeriod extends Model
{
    use HasFactory;
    protected $table = 'payment_periods';
    protected $fillable = [
        'institution_id',
        'year',
        'month',
        'semester',
        'fixed_cost',
        'credit_cost',
        'is_deleted',
    ];
}
