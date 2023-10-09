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
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/user', [App\Http\Controllers\Api\AuthController::class, 'user']);


    Route::get('/cart/ordercancel/{id}', [App\Http\Controllers\Api\CartController::class, 'ordercancel']);
    Route::get('/cart/delivarycancel/{id}', [App\Http\Controllers\Api\CartController::class, 'delivarycancel']);
    Route::get('/cart/removeDish/{id}', [App\Http\Controllers\Api\CartController::class, 'removeDish']);
    Route::get('/cart/removeAllCart', [App\Http\Controllers\Api\CartController::class, 'removeAllCart']);
    Route::get('/cart/delivaryProgress', [App\Http\Controllers\Api\CartController::class, 'delivaryProgress']);
    Route::get('/cart/orderProgress', [App\Http\Controllers\Api\CartController::class, 'orderProgress']);
    Route::get('/cart/formersOrderrestaurant', [App\Http\Controllers\Api\CartController::class, 'formersOrderrestaurant']);
    Route::get('/cart/formersDelivarycaptin', [App\Http\Controllers\Api\CartController::class, 'formersDelivarycaptin']);
    Route::get('/cart/formersOrder', [App\Http\Controllers\Api\CartController::class, 'formersOrder']);
    Route::get('/cart/formersDelivary', [App\Http\Controllers\Api\CartController::class, 'formersDelivary']);
    Route::get('/cart/getCities', [App\Http\Controllers\Api\CartController::class, 'getCities']);
    Route::get('/cart/getCart', [App\Http\Controllers\Api\CartController::class, 'getCart']);
    Route::post('/cart/addDish', [App\Http\Controllers\Api\CartController::class, 'addDish']);
    Route::post('/cart/order/delivaryPrice', [App\Http\Controllers\Api\CartController::class, 'delivaryPriceorder']);
    Route::post('/cart/delivary/delivaryPrice', [App\Http\Controllers\Api\CartController::class, 'delivaryPricedelivary']);
    Route::post('/cart/PlaceADelivary', [App\Http\Controllers\Api\CartController::class, 'PlaceADelivary']);
    Route::post('/cart/PlaceAnOrder', [App\Http\Controllers\Api\CartController::class, 'PlaceAnOrder']);


    Route::get('/profile/getAddressDelivary', [App\Http\Controllers\Api\ProfileController::class, 'getAddressDelivary']);
    Route::get('/profile/addresslist', [App\Http\Controllers\Api\ProfileController::class, 'addresslist']);
    Route::get('/profile/getAddressFood', [App\Http\Controllers\Api\ProfileController::class, 'getAddressFood']);
    Route::post('/profile/changePassword', [App\Http\Controllers\Api\ProfileController::class, 'changePassword']);
    Route::post('/profile/updateInfo', [App\Http\Controllers\Api\ProfileController::class, 'updateInfo']);
    Route::post('/profile/getAddress', [App\Http\Controllers\Api\ProfileController::class, 'getAddress']);
    Route::post('/profile/updateAddress', [App\Http\Controllers\Api\ProfileController::class, 'updateAddress']);


    Route::get('/show/homeUser', [App\Http\Controllers\Api\ShowController::class, 'homeUser']);
    Route::get('/show/homeRestaurant', [App\Http\Controllers\Api\ShowController::class, 'homeRestaurant']);
    Route::get('/show/homeCaptin', [App\Http\Controllers\Api\ShowController::class, 'homeCaptin']);
    Route::get('/show/order/{id}', [App\Http\Controllers\Api\ShowController::class, 'order']);
    Route::get('/show/dish/{id}', [App\Http\Controllers\Api\ShowController::class, 'dish']);
    Route::get('/show/categories', [App\Http\Controllers\Api\ShowController::class, 'categories']);
    Route::get('/show/DishDelete/{id}', [App\Http\Controllers\Api\ShowController::class, 'DishDelete']);
    Route::get('/show/sizedelete/{id}', [App\Http\Controllers\Api\ShowController::class, 'sizedelete']);
    Route::get('/show/landing', [App\Http\Controllers\Api\ShowController::class, 'landing']);
    Route::post('/show/sizeStore', [App\Http\Controllers\Api\ShowController::class, 'sizeStore']);
    Route::post('/show/sizeupdate', [App\Http\Controllers\Api\ShowController::class, 'sizeupdate']);
    Route::post('/show/dishUpdate', [App\Http\Controllers\Api\ShowController::class, 'dishUpdate']);
    Route::post('/show/dishstore', [App\Http\Controllers\Api\ShowController::class, 'dishstore']);
    Route::post('/show/dishes', [App\Http\Controllers\Api\ShowController::class, 'dishes']);
    Route::post('/show/restaurant', [App\Http\Controllers\Api\ShowController::class, 'restaurant']);
});