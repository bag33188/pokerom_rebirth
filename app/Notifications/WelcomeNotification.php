<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    private string $username;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $username = null)
    {
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        $lnMsg = sprintf("%s to the world of Pok%sROM!",
            isset($this->username) ? "$this->username, welcome" : 'Welcome', _EACUTE);
        return (new MailMessage)
            ->subject('Thank you for joining ' . config('app.name') . '!!')
            ->from(config('mail.from.address'))
            ->line($lnMsg)
            ->action('Check it out!', route('roms.index'))
            ->line('enjoy!');
    }
}
