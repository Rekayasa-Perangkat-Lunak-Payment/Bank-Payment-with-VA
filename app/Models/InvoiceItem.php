<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'type',
        'description',
        'cost',
        'quantity',
        'price',
    ];

    // Define the relationship to Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // Define the relationship to ItemType
    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }
}
