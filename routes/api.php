<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
Route::get('/categories/{id}', [\App\Http\Controllers\CategoryController::class, 'show']);
Route::post('/categories/{id}', [\App\Http\Controllers\CategoryController::class, 'update']);
Route::post('/categories', [\App\Http\Controllers\CategoryController::class, 'store']);
Route::delete('/categories/{id}', [\App\Http\Controllers\CategoryController::class, 'delete']);

Route::get('/sub_categories', [\App\Http\Controllers\SubCategoryController::class, 'index']);
Route::get('/sub_categories/{id}', [\App\Http\Controllers\SubCategoryController::class, 'show']);
Route::post('/sub_categories/{id}', [\App\Http\Controllers\SubCategoryController::class, 'update']);
Route::post('/sub_categories', [\App\Http\Controllers\SubCategoryController::class, 'store']);
Route::delete('/sub_categories/{id}', [\App\Http\Controllers\SubCategoryController::class, 'delete']);

Route::get('/actions', [\App\Http\Controllers\ActionController::class, 'index']);
Route::get('/actions/{id}', [\App\Http\Controllers\ActionController::class, 'show']);
Route::post('/actions/{id}', [\App\Http\Controllers\ActionController::class, 'update']);
Route::post('/actions', [\App\Http\Controllers\ActionController::class, 'store']);
Route::delete('/actions/{id}', [\App\Http\Controllers\ActionController::class, 'delete']);

Route::get('/places', [\App\Http\Controllers\PlaceController::class, 'index']);
Route::get('/places/{id}', [\App\Http\Controllers\PlaceController::class, 'show']);
Route::post('/places/{id}', [\App\Http\Controllers\PlaceController::class, 'update']);
Route::post('/places', [\App\Http\Controllers\PlaceController::class, 'store']);
Route::delete('/places/{id}', [\App\Http\Controllers\PlaceController::class, 'delete']);

Route::middleware('auth:api')->group(function() {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});

