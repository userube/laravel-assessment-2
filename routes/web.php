<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TagController;
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

Route::get('/articles', [ArticleController::class, 'getArticles']);
Route::get('/articles/{id}/view', [ArticleController::class, 'incrementViewsCount']);
Route::post('/articles/create', [ArticleController::class, 'store']);
Route::post('/articles/{id}/like', [ArticleController::class, 'storelike']);
Route::post('/articles/{id}/update', [ArticleController::class, 'update']);
Route::post('/articles/{id}/delete', [ArticleController::class, 'destroy']);

Route::get('/comments', [CommentController::class, 'getArticles']);
Route::post('/comments/create', [CommentController::class, 'store']);
Route::get('/comments/{comment}/edit', [CommentController::class, 'edit']);
Route::post('/comments/{comment}/update', [CommentController::class, 'update']);
Route::post('/comments/{comment}/delete', [CommentController::class, 'destroy']);


Route::get('/tags', [TagController::class, 'getTags']);