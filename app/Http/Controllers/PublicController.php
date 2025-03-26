<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class PublicController extends Controller
{
    public function homepage() {
        $articles= Article::where('is_accepted', true)->orderBy('created_at','desc')->take(6)->get();
        return view('welcome',compact('articles'));
    }

    public function searchArticles(Request $request)
    {
        $query=$request->input('query');
        $articles=Article::search($query)->where('is_accepted',true)->paginate(10);
        return view('article.searched',['articles'=>$articles, 'query'=>$query]);
    }
}
