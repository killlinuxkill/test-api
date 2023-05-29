<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{PostsController, TagsController, SearchPostController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('/posts', PostsController::class);
Route::resource('/tags', TagsController::class);

Route::get('/search/posts', [SearchPostController::class, 'byAllContents']);
Route::get('/search/posts-by-title', [SearchPostController::class, 'byTitle']);
Route::get('/search/posts-by-description', [SearchPostController::class, 'byDescription']);
Route::get('/search/posts-by-content', [SearchPostController::class, 'byContent']);
