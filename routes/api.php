<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource('book', BookController::class);
Route::controller(BookController::class)->prefix('book')->group(function () {
    Route::get('/', 'getAllBooks');
    Route::post('/', 'addBook');
    Route::get('{book}', 'getBook');
    Route::put('{book}', 'updateBook');
    Route::delete('{book}', 'deleteBook');
});
