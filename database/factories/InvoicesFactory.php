<?php

namespace Database\Factories;

use App\Models\Invoices;
use App\Models\TandaTerima;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class InvoicesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Invoices::class;

    public function definition(): array
    {
        return [
            'tanda_terima_id' => TandaTerima::factory(),
            'nomor' => $this->faker->unique()->numerify('INV###'),
            'nominal' => $this->faker->numberBetween(1000, 100000),
        ];
    }   
}
