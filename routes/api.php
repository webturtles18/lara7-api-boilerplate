<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get('/products', [ProductController::class, 'index']);
//Route::post('/products', [ProductController::class, 'store']);

// Public Routes
//Route::group(['namespace' => 'Auth'],function(){
//});
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

// Protected Routes
Route::group(['middleware' => 'auth:sanctum'],function () {
    Route::post('/logout',[AuthController::class,'logout']);
    Route::apiResource('products','ProductController'); // Support In Laravel 7+
    //Route::resource('products',ProductController::class); // Support In Laravel 8+
});