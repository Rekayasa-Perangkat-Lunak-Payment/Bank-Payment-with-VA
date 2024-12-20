<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';

    protected $fillable = [
        'virtual_account_id',
        'transaction_date',
        'total',
    ];

    public function virtual_account()
    {
        return $this->belongsTo(VirtualAccount::class);
    }
}
