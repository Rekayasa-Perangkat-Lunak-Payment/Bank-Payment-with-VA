<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualAccount extends Model
{
    use HasFactory;
    protected $table = 'virtual_accounts';

    protected $fillable = [
        'invoice_id',
        'virtual_account_number',
        'expired_at',
        'is_active',
        'total_amount'
    ];
}
