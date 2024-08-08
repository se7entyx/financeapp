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
        $suppliers = Supplier::all();

        TandaTerima::factory()
            ->count(150)
            ->make()
            ->each(function ($tandaTerima) use ($users, $suppliers) {
                $user = $users->random();
                $supplier = $suppliers->random();

                $tandaTerima->user()->associate($user);
                $tandaTerima->supplier()->associate($supplier);
                $tandaTerima->save();

                // Create a random number of invoices for each TandaTerima
                Invoices::factory()
                    ->count(random_int(1, 6))
                    ->create(['tanda_terima_id' => $tandaTerima->id]);
            });
    }
}
