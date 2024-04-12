<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "content",
        "user_id",
        "article_id",
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y年m月d日');
    }
}
