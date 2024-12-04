<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'student_id',
        'payment_period_id',
        'total_amount',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function paymentPeriod()
    {
        return $this->belongsTo(PaymentPeriod::class, 'payment_period_id');
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
