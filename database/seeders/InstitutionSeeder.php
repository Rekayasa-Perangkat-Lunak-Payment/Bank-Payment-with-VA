<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institution;
class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 2; $i++) {
            Institution::create([
                'npsn' => $faker->ean8,
                'name' => $faker->company,
                'status' => 'SWASTA',
                'educational_level' => 'Perguruan Tinggi',
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'account_number' => $faker->bankAccountNumber,
            ]);
        };
    }
}
