<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reminder;
use App\Notifications\ReminderNotification;
use Carbon\Carbon;

class SendReminderNotifications extends Command
{
    protected $signature = 'reminders:notify';
    protected $description = 'Envía notificaciones push de recordatorios pendientes';

    public function handle()
    {
        $now = Carbon::now();
        $reminders = Reminder::where('notified', false)
            ->where('remind_at', '<=', $now)
            ->get();

        foreach ($reminders as $reminder) {
            $reminder->user->notify(new ReminderNotification($reminder));
            $reminder->update(['notified' => true]);
        }

        $this->info('Recordatorios enviados: ' . $reminders->count());
    }
}
