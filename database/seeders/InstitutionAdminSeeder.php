<?php

namespace Database\Seeders;

use App\Models\InstitutionAdmin;
use Illuminate\Database\Seeder;

class InstitutionAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InstitutionAdmin::create([
            'user_id' => 2,
            'institution_id' => 1,
            'name' => 'Admin Sekolah',
            'title' => 'Kepala Sekolah'
        ]);

        InstitutionAdmin::create([
            'user_id' => 3,
            'institution_id' => 1,
            'name' => 'Admin Sekolah 2',
            'title' => 'Biro 2'
        ]);
    }
}
