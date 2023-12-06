<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\OrderHistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin-login', [AdminController::class, 'showAdminLoginForm'])->name('adminLoginPage');
Route::post('/admin-login', [AdminController::class, 'adminLogin'])->name('adminLogin');

Route::group(['middleware' => ['auth:web']], function () {
    Route::get('/list-order-history', [OrderHistoryController::class, 'listOrderHistory'])->name('listOrderHistory');
});

