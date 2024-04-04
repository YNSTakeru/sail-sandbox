<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Tag::factory(40)->create();
        \App\Models\Article::factory(260)->create();

        $this->call([
            ArticleTagSeeder::class,
        ]);
    }
}
