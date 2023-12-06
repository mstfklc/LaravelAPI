<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;



Route::post('device/login', [DeviceController::class, 'deviceLogin'])->middleware('guest');
Route::post('purchase/product', [SubscriptionController::class, 'purchaseProduct'])->middleware('auth:sanctum');
Route::group(['Admin' => 'api','prefix'=>'admin'], function () {
    Route::post('register', [AdminController::class, 'adminRegister']);
});




