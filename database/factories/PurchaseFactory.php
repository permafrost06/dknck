<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'memo_number' => fn() => rand(),
            'date' => fake()->date(),
            'quantity' => fn() => rand(1, 20),
            'mark' => fn() => rand(),
            'ball' => fn() => rand(),
            'goods_of_issues' => fn() => rand(),
            'paid_money' => fn() => rand(),
            'balance_due' => fn() => rand(),
            'comment' => fake()->sentence()
        ];
    }
}
