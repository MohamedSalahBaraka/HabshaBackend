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

    Route::get('/message', [App\Http\Controllers\AdminArea\MessageController::class, 'message'])->name('message');
    Route::get('/message/delete/{id}', [App\Http\Controllers\AdminArea\MessageController::class, 'messageDelete'])->name('message.delete');

    Route::get('order/data', [App\Http\Controllers\AdminArea\OrderController::class, 'Data'])->name('order.Data');
    Route::get('order/restaurant', [App\Http\Controllers\AdminArea\OrderController::class, 'restaurant'])->name('order.restaurant');
    Route::get('order/User', [App\Http\Controllers\AdminArea\OrderController::class, 'User'])->name('order.User');
    Route::get('order/new', [App\Http\Controllers\AdminArea\OrderController::class, 'New'])->name('order.New');
    Route::get('order/show/{id}', [App\Http\Controllers\AdminArea\OrderController::class, 'show'])->name('order.show');
    Route::get('order/cancel/{id}', [App\Http\Controllers\AdminArea\OrderController::class, 'cancel'])->name('order.cancel');
    Route::get('order/delete/{id}', [App\Http\Controllers\AdminArea\OrderController::class, 'Delete'])->name('order.Delete');
    Route::get('order/markAsPaid/{id}', [App\Http\Controllers\AdminArea\OrderController::class, 'markAsPaid'])->name('order.markAsPaid');


    Route::get('user/markAsPaid/{id}', [App\Http\Controllers\AdminArea\CRUD\UserController::class, 'markAsPaid'])->name('user.markAsPaid');
    Route::get('User/address', [App\Http\Controllers\AdminArea\CRUD\UserController::class, 'address'])->name('User.address');
    Route::post('User/addressStore', [App\Http\Controllers\AdminArea\CRUD\UserController::class, 'addressStore'])->name('User.addressStore');

    Route::get('city/fees', [App\Http\Controllers\AdminArea\CRUD\CityController::class, 'fees'])->name('city.fees');
    Route::post('city/feesStore', [App\Http\Controllers\AdminArea\CRUD\CityController::class, 'feesStore'])->name('city.feesStore');

    Route::get('dish/size', [App\Http\Controllers\AdminArea\CRUD\DishController::class, 'size'])->name('dish.size');
    Route::get('dish/sizedelete/{id}', [App\Http\Controllers\AdminArea\CRUD\DishController::class, 'sizedelete'])->name('dish.size.delete');
    Route::post('dish/sizeStore', [App\Http\Controllers\AdminArea\CRUD\DishController::class, 'sizeStore'])->name('dish.sizeStore');
    Route::post('dish/sizeupdate', [App\Http\Controllers\AdminArea\CRUD\DishController::class, 'sizeupdate'])->name('dish.sizeupdate');

    Route::get('User/notifications', [App\Http\Controllers\AdminArea\CRUD\UserController::class, 'notifications'])->name('User.notifications');
    Route::post('User/sendNotifications', [App\Http\Controllers\AdminArea\CRUD\UserController::class, 'sendNotifications'])->name('User.sendNotifications');

    Route::post('delivary/Update', [App\Http\Controllers\AdminArea\DelivariesController::class, 'Update'])->name('delivary.Update');
    Route::post('delivary/store', [App\Http\Controllers\AdminArea\DelivariesController::class, 'store'])->name('delivary.store');
    Route::get('delivary/Captin', [App\Http\Controllers\AdminArea\DelivariesController::class, 'Captin'])->name('delivary.Captin');
    Route::get('delivary/User', [App\Http\Controllers\AdminArea\DelivariesController::class, 'User'])->name('delivary.User');
    Route::get('delivary/data', [App\Http\Controllers\AdminArea\DelivariesController::class, 'Data'])->name('delivary.Data');
    Route::get('delivary/new', [App\Http\Controllers\AdminArea\DelivariesController::class, 'New'])->name('delivary.New');
    Route::post('delivary/asginCaptin', [App\Http\Controllers\AdminArea\DelivariesController::class, 'asginCaptin'])->name('delivary.asginCaptin');
    Route::get('delivary/markAsPaid/{id}', [App\Http\Controllers\AdminArea\DelivariesController::class, 'markAsPaid'])->name('delivary.markAsPaid');
    Route::get('delivary/cancel/{id}', [App\Http\Controllers\AdminArea\DelivariesController::class, 'cancel'])->name('delivary.cancel');
    Route::get('delivary/create', [App\Http\Controllers\AdminArea\DelivariesController::class, 'create'])->name('delivary.create');
    Route::get('delivary/edit/{id}', [App\Http\Controllers\AdminArea\DelivariesController::class, 'edit'])->name('delivary.edit');
    Route::get('delivary/show/{id}', [App\Http\Controllers\AdminArea\DelivariesController::class, 'show'])->name('delivary.show');
    Route::get('delivary/delete/{id}', [App\Http\Controllers\AdminArea\DelivariesController::class, 'Delete'])->name('delivary.Delete');

    Route::get('/setting', [App\Http\Controllers\AdminArea\SettingController::class, 'get'])->name('setting');
    Route::post('/setting', [App\Http\Controllers\AdminArea\SettingController::class, 'SectionStore'])->name('setting.store');

    Route::get('/' . 'Comment' . '/data', [App\Http\Controllers\AdminArea\CommentController::class, 'data'])->name('Comment' . '.data');
    Route::get('/' . 'Comment' . '/emptyTrash', [App\Http\Controllers\AdminArea\CommentController::class, 'emptyTrash'])->name('Comment' . '.emptyTrash');
    Route::get('/' . 'Comment' . '/ParmentlyDelete/{id}', [App\Http\Controllers\AdminArea\CommentController::class, 'ParmentlyDelete'])->name('Comment' . '.ParmentlyDelete');
    Route::get('/' . 'Comment' . '/Action', [App\Http\Controllers\AdminArea\CommentController::class, 'Action'])->name('Comment' . '.Action');
});