<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\http\Controllers\BookController;
use App\http\Controllers\BookReviewController;
use App\http\Controllers\AuthorController;

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

Route::apiResources([
    'books' => BookController::class,
    'authors' => AuthorController::class,
]);
