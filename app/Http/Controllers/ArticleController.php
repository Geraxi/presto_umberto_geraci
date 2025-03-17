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
        return view('article.byCategory',['articles'=> $category->articles, 'category' =>$category]);
    }
}
