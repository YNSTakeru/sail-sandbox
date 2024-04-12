<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'favorite_count' => fake()->numberBetween(0, 100),
            'title' => fake()->realTextBetween(5, 20),
            "abstract" => fake()->realTextBetween(30, 200),
            "content" => fake()->realTextBetween(100, 400),
            'user_id' => fake()->numberBetween(1, User::count()),
            "created_at" => fake()->dateTimeBetween("-1 year"),
        ];
    }
}
