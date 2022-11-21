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
});

Route::group([
    'middleware' => [\Stancl\Tenancy\Middleware\InitializeTenancyByRequestData::class],
], function () {
    Route::get('/tenant-test', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
});

Route::get('test', function () {
    return "ok";
});
