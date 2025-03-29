<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function homepage()
    {
        try {
            $articles = Article::where('is_accepted', true)
                ->with(['user', 'category'])
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();

            return view('welcome', compact('articles'));
        } catch (\Exception $e) {
            return view('welcome', ['articles' => collect()]);
        }
    }

    public function searchArticles(Request $request)
    {
        $query = $request->input('q');
        
        try {
            $articles = Article::where('is_accepted', true)
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('body', 'like', "%{$query}%");
                })
                ->with(['user', 'category'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('article.search', compact('articles', 'query'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error searching articles');
        }
    }
}
