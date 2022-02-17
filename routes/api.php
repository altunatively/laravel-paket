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

Route::fallback(function () {
    return response()->json(['error' => 'Request not found!'], 404);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/package', 'TransactionController@store');

Route::get('/package/{id}', 'TransactionController@show');
Route::get('/package', 'TransactionController@showAll');

Route::put('/package/{id}', 'TransactionController@put');
Route::patch('/package/{id}', 'TransactionController@patch');

Route::delete('/package/{id}', 'TransactionController@delete');
