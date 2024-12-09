<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            Student::create([
                'institution_id' => 1,
                'student_id' => $faker->ean8,
                'name' => $faker->name,
                'year' => $faker->year,
                'email' => $faker->email,
                'major' => $faker->jobTitle,
                'phone' => $faker->phoneNumber,
                'password' => 'password',
            ]);
        };
    }
}
