<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use JetBrains\PhpStorm\ArrayShape;

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
        $lnMsg = "Hello {$this->user->name}, welcome to the world of PokeROM!";
        return (new MailMessage)
            ->subject('Thank you for joining ' . config('app.name') . '!!')
            ->from(config('mail.from.address'))
            ->line(str_replace("PokeROM!", POKE_EACUTE . 'ROM!', $lnMsg))
            ->action('Check it out!', route('roms.index'))
            ->line('Enjoy!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    #[ArrayShape(['subject' => "string", 'from' => "\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed", 'line1' => "array|string|string[]", 'action' => "array", 'line2' => "string"])]
    public function toArray(mixed $notifiable): array
    {
        return [
            'subject' => 'Thank you for joining ' . config('app.name') . '!!',
            'from' => config('mail.from.address'),
            'line1' => str_replace("PokeROM!", POKE_EACUTE . 'ROM!',
                "Hello {$this->user->name}, welcome to the world of PokeROM!"),
            'action' => [
                'hypertext' => 'Check it out!',
                'hyperlink' => route('roms.index')
            ],
            'line2' => 'Enjoy!'
        ];
    }
}
