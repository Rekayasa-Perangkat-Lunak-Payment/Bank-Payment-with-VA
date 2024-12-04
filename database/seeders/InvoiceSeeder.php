<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Invoice::create([
            'student_id' => 1,
            'payment_period_id' => 1,
            'total_amount' => '12000000',
        ]);

        Invoice::create([
            'student_id' => 2,
            'payment_period_id' => 1,
            'total_amount' => '12000000',
        ]);

        Invoice::create([
            'student_id' => 3,
            'payment_period_id' => 1,
            'total_amount' => '12000000',
        ]);
    }
}
