<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\SendsController;
use App\Http\Controllers\HistoryController;

// HomeController routes
Route::controller(HomeController::class)->group(function () {
    Route::get('/','index')->name('home');
});

// NotificationsController routes
Route::controller(NotificationsController::class)->group(function () {
    Route::get('notifications','index')->name('notifications');
    Route::get('notifications/newNotification','new')->name('newNotification');
    Route::post('notifications/saveNotification','save')->name('saveNotification');
    Route::put('notifications/sendNotification/{id}','send')->name('sendNotification');
});

Route::controller(SendsController::class)->group(function () {
    Route::post('send/all/{id?}/{message?}/{user?}','all')->name('sendAll');
    Route::post('send/sms/{id?}/{message?}/{user?}','sendSMS')->name('sendSMS');
    Route::post('send/email/{id?}/{message?}/{user?}','sendEMail')->name('sendEMail');
    Route::post('send/pushn/{id?}/{message?}/{user?}','sendPushN')->name('sendPushN');
});

Route::controller(HistoryController::class)->group(function () {
    Route::get('history/db','db')->name('historyDB');
});

