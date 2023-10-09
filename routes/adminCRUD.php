<?php

use Illuminate\Routing\Controllers\Middleware;
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

Route::prefix('admin/dashbord')->name('admin.')->middleware('auth')->group(function () {
    // Route::prefix('admin/dashbord')->name('admin.')->group(function () {
    $arrayCRUD = [
        'City' => App\Http\Controllers\AdminArea\CRUD\CityController::class,
        'Page' => App\Http\Controllers\AdminArea\CRUD\PageController::class,
        'Category' => App\Http\Controllers\AdminArea\CRUD\CategoryController::class,
        'User' => App\Http\Controllers\AdminArea\CRUD\UserController::class,
        'Dish' => App\Http\Controllers\AdminArea\CRUD\DishController::class,

    ];
    foreach ($arrayCRUD as $key => $var) {
        Route::get('/' . $key . '/Data', [$var, 'Data'])->name($key . '.Data');
        Route::get('/' . $key . '/Model', [$var, 'model'])->name($key . '.Model');
        Route::get('/' . $key . '/ParmentlyDelete/{id}', [$var, 'ParmentlyDelete'])->name($key . '.ParmentlyDelete');
        Route::post('/' . $key . '/store', [$var, 'store'])->name($key . '.store');
        Route::post('/' . $key . '/Update', [$var, 'Update'])->name($key . '.Update');
    }

});