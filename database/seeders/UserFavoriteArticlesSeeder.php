<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use App\Models\UserFavoriteArticles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserFavoriteArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::all()->each(function ($article) {
            $randomNumber = rand(0, User::count());

            $users = User::inRandomOrder()->take($randomNumber)->get();

            $users->each(function ($user) use ($article) {
                UserFavoriteArticles::factory()->create([
                    "user_id" => $user->id,
                    "article_id" => $article->id,
                ]);
            });
        });
    }
}
