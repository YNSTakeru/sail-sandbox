<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            "content" => "required|string|max:255",
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = $request->user()->id;
        $comment->article_id = $request->id;
        $comment->save();


        return redirect()->route("articles.show", ["id" => $request->id]);
    }
}
