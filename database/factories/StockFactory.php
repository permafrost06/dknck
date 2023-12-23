<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'item_code' => fake()->words(2, true),
            'date_time' => fake()->dateTime(),
            'brand' => fake()->words(3, true),
            'quantity' => fn() => floor(fake()->numberBetween(100, 500) / 10) * 10,
            'unit_cost' => fn() => [500, 700, 900][rand(0, 2)],
            'adjustment' => fake()->numberBetween(-3000, -5000),
            'merchant_name' => fake()->name(),
            'merchant_contact' => fake()->phoneNumber(),
            'carrier_name' => fn($attrs) => isset($attrs['type']) && $attrs['type'] == 'in'?fake()->name():null,
            'carrier_contact' => fn($attrs) => isset($attrs['type']) && $attrs['type'] == 'in'?fake()->phoneNumber():null,
            'border' => fn($attrs) => isset($attrs['type']) && $attrs['type'] == 'in'?fake()->words(3, true):null,
            'remarks' => null,
        ];
    }
}
