<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;


Route::group(['middleware' => ['guest']], function () {
    Route::post('device/login', [DeviceController::class, 'deviceLogin']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('purchase/product', [SubscriptionController::class, 'purchaseProduct']);
});

Route::group(['Admin' => 'api','prefix'=>'admin'], function () {
    Route::post('register', [AdminController::class, 'adminRegister']);
    Route::post('login', [AdminController::class, 'adminLogin']);
});

Route::group(['middleware' => ['auth:sanctum'],'prefix'=>'admin'], function () {
    Route::get('list-order', [AdminController::class, 'listOrderHistory']);
});

