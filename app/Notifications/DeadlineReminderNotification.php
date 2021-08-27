<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeadlineReminderNotification extends Notification
{
    use Queueable;

    private $lendings;
    private $no_of_days_before_deadline;
    private $user_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($lendings, $no_of_days_before_deadline, $user_name)
    {
        $this->lendings = $lendings;
        $this->no_of_days_before_deadline = $no_of_days_before_deadline;
        $this->user_name = $user_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                                ->from('unilib@mail.com', 'UniLib')
                                ->view('emails.deadline_reminder', ['lendings' => $this->lendings, 'days_left' => $this->no_of_days_before_deadline, 'user_name' => $this->user_name])
                                ->subject('UniLib Deadline Reminder');
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
