<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankAdmin;
class BankAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BankAdmin::create([
            'user_id' => 1,
            'name' => 'Admin Bank',
            'nik' => '234567765544'
        ]);
    }
}
