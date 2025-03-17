<?php

namespace App\Http\Controllers;

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Midleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Models\Article;
use App\Models\Category;


class ArticleController extends Controller implements HasMiddleware
{
   
   public static function middleware(): array
   {
        return[
            new Middleware('auth',only:['create']),
        ];
    }
   
    public function create(){
        return view('article.create');
    }

    public function show(Article $article){
        return view('article.show',compact('article'));
    }

    public function byCategory(Category $category){
        $articles= $category->articles->where('is_accepted',true);
        return view('article.byCategory',compact('articles','category'));
    }

    public function index()
    {
        $articles= Article::where('is_accepted',true)->orderBy('created_at','desc')->paginate(10);
        return view('article.index',compact('articles'));
    }
}
