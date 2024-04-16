<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "abstract",
        "content",
        "user_id",
        "favorite_count",
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y年m月d日');
    }

    public function author()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function articleTags(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, Tag::class);
    }
}
