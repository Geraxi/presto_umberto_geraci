<?php

namespace App\Http\Controllers;

use App\Mail\BecomeRevisor;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class RevisorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->except(['becomeRevisor']);
        $this->middleware(['isRevisor'])->except(['becomeRevisor']);
    }

    public function index()
    {
        try {
            $article_to_check = Article::where('is_accepted', null)
                ->with(['user', 'category', 'images'])
                ->first();

            return view('revisor.index', compact('article_to_check'));
        } catch (\Exception $e) {
            return redirect()->route('homepage')->with('error', 'Error loading articles to review');
        }
    }

    public function accept(Article $article)
    {
        try {
            if ($article->is_accepted !== null) {
                return redirect()->back()->with('error', 'Article already reviewed');
            }

            $article->setAccepted(true);
            return redirect()
                ->back()
                ->with('message', "Article '{$article->title}' has been accepted");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error accepting article');
        }
    }

    public function reject(Article $article)
    {
        try {
            if ($article->is_accepted !== null) {
                return redirect()->back()->with('error', 'Article already reviewed');
            }

            $article->setAccepted(false);
            return redirect()
                ->back()
                ->with('message', "Article '{$article->title}' has been rejected");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error rejecting article');
        }
    }

    public function becomeRevisor()
    {
        try {
            if (Auth::user()->is_revisor) {
                return redirect()->route('homepage')->with('error', 'You are already a revisor');
            }

            Mail::to('admin@presto.it')->send(new BecomeRevisor(Auth::user()));
            return redirect()
                ->route('homepage')
                ->with('message', 'Thank you for your request to become a revisor');
        } catch (\Exception $e) {
            return redirect()->route('homepage')->with('error', 'Error processing your request');
        }
    }

    public function makeRevisor(User $user)
    {
        try {
            if ($user->is_revisor) {
                return redirect()->back()->with('error', 'User is already a revisor');
            }

            Artisan::call('app:make-user-revisor', ['email' => $user->email]);
            return redirect()->back()->with('message', 'User has been made a revisor');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error making user a revisor');
        }
    }
}
