<?php

namespace App\Notifications;

use App\Notifications\Base\CustomBaseNotification;
use App\Notifications\Channels\ThirdPartyNotificationChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class WelcomeNotification extends CustomBaseNotification{
    use Queueable;

    public function viaThirdPartyService(object $notifiable){
        Log::info(message: 'WelcomeNotification notification ---------------');
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [ThirdPartyNotificationChannel::class];
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
