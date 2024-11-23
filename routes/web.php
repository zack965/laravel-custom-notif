<?php

use App\Models\User;
use App\Notifications\ThankForYourFeedbackNotification;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});





Route::get(uri: '/send-notif', action: function () {
    $user = User::first();
    $user->notify(new ThankForYourFeedbackNotification());
    $user->notify(new WelcomeNotification());
    return "ok";
});

