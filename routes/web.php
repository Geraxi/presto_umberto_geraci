<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RevisorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', [PublicController::class, 'homepage'])->name('homepage');

// Article routes
Route::get('/article/index', [ArticleController::class, 'index'])->name('article.index');
Route::get('/create/article', [ArticleController::class, 'create'])->name('create.article')->middleware('auth');
Route::post('/store/article', [ArticleController::class, 'store'])->name('store.article')->middleware('auth');
Route::get('/show/article/{article}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/category/{category}', [ArticleController::class, 'byCategory'])->name('article.byCategory');

// Revisor routes
Route::middleware(['auth', 'isRevisor'])->group(function () {
    Route::get('/revisor/index', [RevisorController::class, 'index'])->name('revisor.index');
    Route::get('/accept/{article}', [RevisorController::class, 'accept'])->name('accept');
    Route::get('/reject/{article}', [RevisorController::class, 'reject'])->name('reject');
});

Route::get('/revisor/request', [RevisorController::class, 'BecomeRevisor'])->middleware('auth')->name('become.revisor');
Route::get('/make/revisor/{user}', [RevisorController::class, 'makeRevisor'])->name('make.revisor');

// Search route
Route::get('/search/article/', [PublicController::class, 'searchArticles'])->name('article.search');



