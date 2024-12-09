<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VirtualAccount;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VirtualAccount::create([
            'invoice_id' => 1,
            'virtual_account_number' => '1234567890',
            'expired_at' => '2024-12-31',
            'total_amount' => 100000,
            'is_active' => true
        ]);
    }
}
