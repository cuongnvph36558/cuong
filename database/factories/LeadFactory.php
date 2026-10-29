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
            'coupon_code' => 'ELICPO10',
            'variant' => fake()->randomElement(['Đạm Cá Amino 1L', 'Đạm Cá Amino 5L']),
            'plant_type' => fake()->randomElement(['Cây ăn trái', 'Rau màu', 'Hoa, cây cảnh']),
            'symptoms' => fake()->randomElements(['VÀNG LÁ', 'THỐI RỂ', 'CÂY CÒI CỌC'], 2),
            'note' => fake()->sentence(),
            'source' => 'landing',
        ];
    }
}
