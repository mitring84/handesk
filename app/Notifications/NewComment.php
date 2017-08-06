<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewComment extends Notification
{
    use Queueable;

    public $ticket;
    public $comment;

    public function __construct($ticket, $comment) {
        $this->ticket = $ticket;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return (isset($notifiable->slack_webhook_url) && $notifiable->slack_webhook_url != null) ? ['slack'] : ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A new comment for the ticket')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->content('Ticket updated');
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}