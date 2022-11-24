<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

\Illuminate\Support\Facades\Broadcast::routes(['middleware' => ['universal', \Stancl\Tenancy\Middleware\InitializeTenancyByRequestData::class, 'auth:sanctum']]);

Route::group([
    'middleware' => ['universal', \Stancl\Tenancy\Middleware\InitializeTenancyByRequestData::class, 'auth:sanctum'],
], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('/test-central', function (Request $request) {
        return "central";
    });
    Route::get('/dispatch-test-event', function (Request $request) {
        dispatch(new \App\Events\Test())->onConnection('central');
        return "emitted";
    });
});

Route::group([
    'middleware' => [\Stancl\Tenancy\Middleware\InitializeTenancyByRequestData::class, 'auth:sanctum'],
], function () {
    Route::post("/logout", [\App\Http\Controllers\LoginController::class, "logout"]);
    Route::get('/test-tenant', function (Request $request) {
        return "tenant";
    });
    Route::get('/tenant-dispatch-test-event', function (Request $request) {
        \App\Events\Test::dispatch();
        return "emitted";
    });
});

Route::get('test', function () {
    return "ok";
});
