<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Supplier;
use App\Models\TandaTerima;
use App\Models\Invoice;
use App\Models\Invoices;
use Illuminate\Database\Seeder;

class TandaTerimaSeeder extends Seeder
{
    public function run()
    {
        // Fetch all users
        $users = User::all();

        // Loop through each user
        foreach ($users as $user) {
            // Each user can have multiple TandaTerima
            TandaTerima::factory()
                ->count(10)
                ->for($user) // Associate with the current user
                ->for(Supplier::inRandomOrder()->first()) // Associate with a random supplier
                ->has(
                    Invoices::factory()->count(random_int(1, 6)), // Create 1-6 invoices for each TandaTerima
                    'invoices'
                )
                ->create();
        }
    }
}
