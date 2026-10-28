<?php

namespace Database\Factories;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feedback>
 */
class FeedbackFactory extends Factory
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
            'role' => fake()->randomElement([
                'Chủ trại cà phê Gia Lai',
                'Chủ trại bưởi Vĩnh Long',
                'Nhà vườn Lâm Đồng',
            ]),
            'rating' => fake()->numberBetween(4, 5),
            'content' => fake()->sentence(12),
            'image' => null,
            'photos' => [],
            'is_featured' => fake()->boolean(30),
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
