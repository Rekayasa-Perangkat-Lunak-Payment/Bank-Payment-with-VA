<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemType;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemType::create([
            'institution_id' => 1,
            'name' => 'Biaya Pokok Pendidikan',
            'description' => 'Biaya pokok pendidikan',
            'is_deleted' => false
        ]);

        ItemType::create([
            'institution_id' => 1,
            'name' => 'Biaya Variabel Pendidikan',
            'description' => 'Biaya variabel pendidikan',
            'is_deleted' => false
        ]);

        ItemType::create([
            'institution_id' => 1,
            'name' => 'Biaya ICE',
            'description' => 'Biaya pelatihan pendidikan bahasa Inggris',
            'is_deleted' => false
        ]);
    }
}
