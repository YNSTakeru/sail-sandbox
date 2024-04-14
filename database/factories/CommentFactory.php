<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "content" => fake()->realTextBetween(30, 120),
            "user_id" => fake()->numberBetween(1, User::count()),
            "article_id" => fake()->numberBetween(1, Article::count()),
            "created_at" => fake()->dateTimeBetween("-1 year"),
        ];
    }
}
