<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class ReminderNotification extends Notification
{
    use Queueable;

    public $reminder;

    public function __construct($reminder)
    {
        $this->reminder = $reminder;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('🕒 Recordatorio: ' . $this->reminder->title)
            ->body($this->reminder->description ?? 'Tienes un recordatorio pendiente.')
            ->action('Ver recordatorio', '/recordatorios')
            ->data(['id' => $this->reminder->id]);
    }
}
