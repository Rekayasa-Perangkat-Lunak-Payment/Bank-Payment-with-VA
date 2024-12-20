<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $table = 'invoice_items';
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'invoice_id',
        'item_type_id',
        'description',
        'unit_price',
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
