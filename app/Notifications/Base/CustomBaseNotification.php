<?php
namespace App\Notifications\Base;
use Illuminate\Notifications\Notification;

abstract class CustomBaseNotification extends Notification{
    abstract public function viaThirdPartyService(object $notifiable);
}
