<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;


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

Route::group(['prefix' => 'media'], function () {
    Route::get('/', [MediaController::class, 'index'])->name('media.index');
    Route::post('/', [MediaController::class, 'store'])->name('media.store');
    Route::get('/{media}', [MediaController::class, 'show'])->name('media.show');
    Route::post('/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
