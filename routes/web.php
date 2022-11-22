<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => ['universal', \Stancl\Tenancy\Middleware\InitializeTenancyByRequestData::class],
], function () {
    Route::post("/login", [\App\Http\Controllers\LoginController::class, "authenticate"]);
    Route::post("/logout", [\App\Http\Controllers\LoginController::class, "logout"]);
});

// Needed for sanctum to work with Tenancy for Laravel package
Route::group(['prefix' => config('sanctum.prefix', 'sanctum')], static function () {
    Route::get('/csrf-cookie',[\Laravel\Sanctum\Http\Controllers\CsrfCookieController::class, 'show'])
        // Use tenancy initialization middleware of your choice
        ->middleware(['universal', 'web', \Stancl\Tenancy\Middleware\InitializeTenancyByRequestData::class])
        ->name('sanctum.csrf-cookie');
});
