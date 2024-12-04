<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentPeriod;
use Faker\Provider\ar_EG\Payment;

class PaymentPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentPeriod::create([
            'institution_id' => 1,
            'year' => 2023,
            'month' => 12,
            'semester' => 'GANJIL',
            'fixed_cost' => 3500000,
            'credit_cost' => 300000
        ]);

        PaymentPeriod::create([
            'institution_id' => 1,
            'year' => 2024,
            'month' => 1,
            'semester' => 'GENAP',
            'fixed_cost' => 3500000,
            'credit_cost' => 300000
        ]);
    }
}
