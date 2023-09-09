<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationsController;

// HomeController routes
Route::controller(HomeController::class)->group(function () {
    Route::get('/','index')->name('home');
});

// NotificationsController routes
Route::controller(NotificationsController::class)->group(function () {
    Route::get('notifications','index')->name('notifications');
    Route::get('newNotification','new')->name('newNotification');
    Route::post('saveNotification','save')->name('saveNotification');
    Route::get('notificationDetails','notificationDetails')->name('notificationDetails');
});
