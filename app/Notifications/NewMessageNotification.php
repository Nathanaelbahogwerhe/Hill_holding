<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        // Envoie dans la base et par email
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📩 Nouveau message reçu')
            ->greeting('Bonjour ' . $notifiable->first_name . ',')
            ->line('Vous avez reçu un nouveau message de ' . $this->message->sender->full_name . '.')
            ->line('Sujet : ' . $this->message->subject)
            ->action('Lire le message', url(route('messages.show', $this->message->id)))
            ->line('Merci de votre collaboration.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message_id' => $this->message->id,
            'sender_name' => $this->message->sender->full_name,
            'subject' => $this->message->subject,
        ];
    }
}




