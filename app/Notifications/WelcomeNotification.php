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

    private const APP_NAME_TEXT = "PokeROM!";
    private string $welcomeMessage;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public User $user)
    {
        $this->welcomeMessage = sprintf("Hello %s, welcome to the world of %s", $this->user->name, self::APP_NAME_TEXT);
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
        return (new MailMessage)
            ->subject('Thank you for joining ' . config('app.name') . '!!')
            ->from(config('mail.from.address'))
            ->line(
                str_replace(
                    search: self::APP_NAME_TEXT,
                    replace: sprintf("%sROM!", POKE_EACUTE),
                    subject: $this->welcomeMessage
                )
            )
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
            'line1' => str_replace(
                search: self::APP_NAME_TEXT,
                replace: sprintf("%sROM!", POKE_EACUTE),
                subject: $this->welcomeMessage
            ),
            'action' => [
                'hypertext' => 'Check it out!',
                'hyperlink' => route('roms.index')
            ],
            'line2' => 'Enjoy!'
        ];
    }
}
