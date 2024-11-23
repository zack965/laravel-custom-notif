<?php
namespace App\Notifications\Channels;

use App\Notifications\Base\CustomBaseNotification;

class ThirdPartyNotificationChannel {
    public function send(object $notifiable, CustomBaseNotification $notification): void
    {
        $notification->viaThirdPartyService(notifiable: $notifiable);
    }
}
