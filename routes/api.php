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

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/test-central', function (Request $request) {
        return "central";
    });
});

Route::group([
    'middleware' => [\Stancl\Tenancy\Middleware\InitializeTenancyByRequestData::class, 'auth:sanctum'],
], function () {
    Route::get('/tenant-user', function (Request $request) {
        return $request->user();
    });

    Route::get('/test-tenant', function (Request $request) {
        return "tenant";
    });
});

Route::get('test', function () {
    return "ok";
});
