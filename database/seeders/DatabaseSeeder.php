<?php

namespace Database\Seeders;

use Doctrine\DBAL\Event\TransactionEventArgs;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            InstitutionSeeder::class,
            StudentSeeder::class,
            BankAdminSeeder::class,
            InstitutionAdminSeeder::class,
            ItemTypeSeeder::class,
            PaymentPeriodSeeder::class,
            InvoiceSeeder::class,
            InvoiceItemSeeder::class,
            VirtualAccountSeeder::class,
            TransactionSeeder::class
        ]);
    }
}
