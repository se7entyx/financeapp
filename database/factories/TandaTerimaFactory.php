<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\TandaTerima;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TandaTerima>
 */
class TandaTerimaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TandaTerima::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'supplier_id' => Supplier::factory(),
            'tanggal' => Carbon::now()->format('d-m-Y'),
            'pajak' => $this->faker->randomElement(['true', 'false']),
            'po' => $this->faker->randomElement(['true', 'false']),
            'bpb' => $this->faker->randomElement(['true', 'false']),
            'surat_jalan' => $this->faker->randomElement(['true', 'false']),
            'tanggal_jatuh_tempo' => Carbon::now()->addDays(rand(1, 365))->format('d-m-Y'),
            'keterangan' => $this->faker->sentence,
        ];
    }
}
