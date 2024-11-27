# Laravel custom notification channel

#### In a Laravel application, you might need to send emails through a third-party service using API calls instead of the default mail driver. To do this, you can create a custom notification channel to integrate with the API. But how do you achieve this ?

### Custom Notification base class

To achieve this, we need to create an abstract class with an abstract method that will be implemented by all notifications sent through the custom notification channel.

```php
<?php
namespace App\Notifications\Base;
use Illuminate\Notifications\Notification;

abstract class CustomBaseNotification extends Notification{
    abstract public function viaThirdPartyService(object $notifiable);
}

```

### Create Notification custom channel

```php
<?php
namespace App\Notifications\Channels;

use App\Notifications\Base\CustomBaseNotification;

class ThirdPartyNotificationChannel {
    public function send(object $notifiable, CustomBaseNotification $notification): void
    {
        $notification->viaThirdPartyService(notifiable: $notifiable);
    }
}

```

### Update Notification class

In any class that needs to send notifications through this custom channel, we must update the class to extend from `CustomBaseNotification`. Additionally, we need to include the custom channel in the `via` function's channel array. Here's an example :

```php
<?php

namespace App\Notifications;

use App\Notifications\Base\CustomBaseNotification;
use App\Notifications\Channels\ThirdPartyNotificationChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ThankForYourFeedbackNotification extends CustomBaseNotification
{
    use Queueable;


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [ThirdPartyNotificationChannel::class];
    }

    public function viaThirdPartyService(object $notifiable){
        Log::info('ThankForYourFeedbackNotification notification ---------------');
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

```

and the second notification :

```php
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

```

## What you need to change ?

##### In each notification, you can override the `viaThirdPartyService` function to implement custom API calls to the third-party service, allowing you to tailor the integration to your specific needs.

## And to test this in pest :

```php
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

```
