<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmationIntervention extends Notification
{
    use Queueable;

    protected $intervention;
    protected $messageContent;

    /**
     * Create a new notification instance.
     */
    public function __construct($intervention, $messageContent)
    {
        $this->intervention = $intervention;
        $this->messageContent = $messageContent;
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
            ->subject('Confirmation de votre intervention - ' . $this->intervention->code)
            ->from('infos@plateau-apps.com', 'Prestataire AF')
            ->view('emails.interventions.confirmation', [
                'intervention' => $this->intervention,
                'messageContent' => $this->messageContent
            ]);
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
