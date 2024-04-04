<?php

namespace App\Http\Controllers;

use App\Models\ApiArticle;
use App\Models\Article;
use Illuminate\Http\Request;

class ApiArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        return response()->json($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ApiArticle $apiArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApiArticle $apiArticle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApiArticle $apiArticle)
    {
        //
    }
}
