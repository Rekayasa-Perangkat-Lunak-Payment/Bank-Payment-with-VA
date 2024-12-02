<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'adminbank',
            'email' => 'adminbank@gmail.com',
            'password' => 'admin',
        ]);

        User::create([
            'username' => 'adminsekolah',
            'email' => 'adminsekolah@gmail.com',
            'password' => 'admin',
        ]);
    }
}
