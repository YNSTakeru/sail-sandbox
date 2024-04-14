<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Article;
use App\Models\ArticleTag;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {



        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            "bio" => ["string", "max:255", "nullable"],
            "avatar" => ["url", "max:255", "nullable"],
        ]);

        $user = User::find(Auth::id());
        $user->email = $request->email;

        if($user->email !== $request->email) {
            $request->validate([
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            ]);
        }

        $user->name = $request->name;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }

        $profile = Profile::where('user_id', $user->id)->first();


        $profile->bio = $request->bio;
        $user->save();
        $profile->save();


        return to_route("settings");
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function index($id)
    {
        $user = User::find($id);
        $articles = Article::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(10);

        $articleTags = Article::select("article_tags.*")->where('user_id', $id)->orderBy('created_at', 'desc')->join('article_tags', 'articles.id', '=', 'article_tags.article_id')->get();

        return view('profile', compact("user", "articles", "articleTags"));
    }

    public function show()
    {

        $user = User::find(Auth::id());
        $profile = Profile::where('user_id', Auth::id())->first();

        return view('settings', compact("user", "profile"));
    }


}
