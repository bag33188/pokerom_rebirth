<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public User $user)
    {
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
        $lnMsg = (isset($this->user->name) ? "Hello {$this->user->name}, welcome" : 'Welcome') . " to the world of PokeROM!";
        return (new MailMessage)
            ->subject('Thank you for joining ' . config('app.name') . '!!')
            ->from(config('mail.from.address'))
            ->line(preg_replace("/Poke/i", POKE_EACUTE, $lnMsg))
            ->action('Check it out!', route('roms.index'))
            ->line('Enjoy!');
    }
}
