<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::create([
            'virtual_account_id' => 1,
            'transaction_date' => '2023-01-01',
            'total' => 100000
        ]);
    }
}
