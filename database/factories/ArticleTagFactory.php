<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleTag>
 */
class ArticleTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // タブってキーができると使えないー
        return [
            "article_id" => fake()->numberBetween(1, Article::count()),
            "tag_id" => fake()->numberBetween(1, Tag::count()),
        ];
    }
}
