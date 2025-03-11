<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrphanTranslationsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public array $details)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('command.orphan_translations_found'))
            ->greeting('Hi '.$notifiable->name.',')
            ->line(__('command.orphan_translations_missing_records'))
            ->line(json_encode($this->details['missingRecords'], JSON_PRETTY_PRINT))
            ->line(__('command.orphan_translations_missing_fields'))
            ->line(json_encode($this->details['missingFields'], JSON_PRETTY_PRINT))
            ->action(__('translation.translations_index_headline'), url('/translations/'))
            ->line(__('command.orphan_translations_missing_correction'));
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
