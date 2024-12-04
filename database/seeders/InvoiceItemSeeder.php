<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoiceItem;
class InvoiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvoiceItem::create([
            'invoice_id' => 1,
            'item_type_id' => 1,
            'description' => 'Biaya Pokok Pendidikan Dasar 2023',
            'cost' => 120000,
            'quantity' => 10,
            'price' => 1200000
        ]);
    }
}
