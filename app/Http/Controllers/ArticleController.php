<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $cache;

    public function __construct(CacheContract $cache)
    {
        $this->cache = $cache;
        $this->middleware(['auth'])->except(['index', 'show', 'byCategory']);
    }

    public function index()
    {
        try {
            $articles = Article::where('is_accepted', true)
                ->with(['user', 'category', 'images'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
                
            return view('article.index', compact('articles'));
        } catch (\Exception $e) {
            return redirect()->route('homepage')->with('error', 'Error loading articles');
        }
    }

    public function create()
    {
        try {
            $categories = Category::all();
            return view('article.create', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->route('homepage')->with('error', 'Error loading categories');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|min:3',
                'body' => 'required|min:10',
                'category_id' => 'required|exists:categories,id',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $article = Auth::user()->articles()->create([
                'title' => $validated['title'],
                'body' => $validated['body'],
                'category_id' => $validated['category_id'],
                'is_accepted' => null
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('public/articles');
                    $article->images()->create([
                        'path' => $path
                    ]);
                }
            }

            return redirect()->route('homepage')->with('message', 'Article created successfully and pending review');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error creating article');
        }
    }

    public function show(Article $article)
    {
        try {
            if (!$article->is_accepted && !Auth::user()?->is_revisor) {
                return redirect()->route('homepage')->with('error', 'Article not available');
            }

            $article->load(['user', 'category', 'images']);
            return view('article.show', compact('article'));
        } catch (\Exception $e) {
            return redirect()->route('homepage')->with('error', 'Error loading article');
        }
    }

    public function byCategory(Category $category)
    {
        try {
            $articles = $this->cache->remember('category_articles_' . $category->id, 3600, function () use ($category) {
                return $category->articles()
                    ->where('is_accepted', true)
                    ->with(['user', 'category', 'images'])
                    ->orderBy('created_at', 'desc')
                    ->get();
            });
            
            return view('article.byCategory', compact('articles', 'category'));
        } catch (\Exception $e) {
            return redirect()->route('homepage')->with('error', 'Error loading category articles');
        }
    }
}
