<?php

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReviewController;
use App\Http\Controllers\AuthorController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'books'], function () {
    Route::apiResource('/reviews', BookReviewController::class);
});

Route::group(['prefix' => 'authors'], function () {
    Route::get('/{author_id}/books', [BookController::class, 'index']);
});

Route::apiResources([
    'books' => BookController::class,
    'authors' => AuthorController::class,
]);
