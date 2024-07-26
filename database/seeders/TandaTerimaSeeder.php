<?php

namespace Database\Seeders;

use App\Models\Invoices;
use App\Models\Supplier;
use App\Models\TandaTerima;
use App\Models\User;
use Illuminate\Database\Seeder;

class TandaTerimaSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $suppliers = Supplier::all();


        TandaTerima::factory()
            ->count(100)
            ->recycle($users) // Assign users to TandaTerima
            ->create()
            ->each(function ($tanda_terima) use ($suppliers) {
                // Assign a random supplier to each TandaTerima
                $tanda_terima->supplier()->associate($suppliers->random());

                // Create multiple Invoices for each TandaTerima
                Invoices::factory()
                    ->count(rand(1, 6))
                    ->for($tanda_terima) // Associate each invoice with the TandaTerima
                    ->create();
            });
    }
}
