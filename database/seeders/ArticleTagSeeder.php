<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::all();
        $tags = Tag::all();


        foreach ($articles as $article) {
        $generateCount = random_int(1, 2);
        $tags = $tags->shuffle();
            foreach ($tags as $tag) {
                ArticleTag::firstOrCreate([
                    'article_id' => $article->id,
                    'tag_id' => $tag->name,
                ]);
                if ($generateCount-- <= 0)
                break;
            }
        }
    }
}
