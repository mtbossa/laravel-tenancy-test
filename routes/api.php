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

// Needed for channels to work both with Sanctum and Tenancy for Lravel
\Illuminate\Support\Facades\Broadcast::routes(['middleware' => ['universal', \Stancl\Tenancy\Middleware\InitializeTenancyByRequestData::class, 'auth:sanctum']]);


// Common routes for central and tenant app
Route::group([
    'middleware' => ['universal', \Stancl\Tenancy\Middleware\InitializeTenancyByRequestData::class, 'auth:sanctum'],
], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// Central routes only
Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('/test-central', function (Request $request) {
        return ["central", "user" => $request->user()];
    });
    Route::get('/dispatch-test-event', function (Request $request) {
        event(new \App\Events\Test(true));
        return "emitted";
    });
});

Route::group([
    'middleware' => [\Stancl\Tenancy\Middleware\InitializeTenancyByRequestData::class, 'auth:sanctum'],
], function () {
    Route::get('/test-tenant', function (Request $request) {
        return ["tenant", "user" => $request->user()];
    });
    Route::get('/tenant-dispatch-test-event', function (Request $request) {
        \App\Events\Test::dispatch();
        return "emitted";
    });
});

Route::get('test', function () {
    return "ok";
});
