<?php
use App\Models\User;
use App\Notifications\ThankForYourFeedbackNotification;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

test('route sends both ThankForYourFeedbackNotification and WelcomeNotification', function () {
    Notification::fake();
    $user =User::first();
    $response = $this->get('/send-notif');
    Notification::assertSentTo(
        $user,
        ThankForYourFeedbackNotification::class
    );
    Notification::assertSentTo(
        $user,
        WelcomeNotification::class
    );
});
