<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->numerify('09########'),
            'address' => fake()->address(),
            'coupon_code' => 'HT212',
            'plant_type' => fake()->randomElement(['Cây ăn quả', 'Cây cảnh', 'Bonsai', 'Cây rau, củ']),
            'symptoms' => fake()->randomElements(['VÀNG LÁ', 'THỐI RỄ', 'CÂY CÒI CỌC'], 2),
            'note' => fake()->sentence(),
            'source' => 'landing',
        ];
    }
}
