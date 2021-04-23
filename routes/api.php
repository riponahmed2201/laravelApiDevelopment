<?php

use App\Http\Controllers\APIController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//GET API - Fetch one or more records
Route::get('users/{id?}', [APIController::class,'getUsers']);

//POST API - Add single user
Route::post('add-users', [APIController::class,'addUsers']);

//POST API - Add multiple users
Route::post('add-multiple-users',[APIController::class,'addMultipleUsers']);
