<?php

namespace Database\Factories;

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
            'title' => fake()->unique()->sentence(),
            "content" => fake()->paragraph(),
            'user_id' => UserFactory::new(),
            'tag_id' => TagFactory::new(),
        ];
    }
}
