<?php

namespace App\Notifications;

use App\Subscription;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionDue extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $subscription;
    public function __construct(array $subscription)
    {
        $this->subscription = $subscription;
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

    public function shouldInterrupt($notifiable)
    {
        $update = Subscription::find($this->subscription['subscription']->id);
        if ($update === NULL) {
            return true;
        }
        if ($update->allow_notifs == 0) {
            return true;
        }
        return Carbon::parse($update->next_date)->format('Y-m-d') !== Carbon::now()->addDay()->format('Y-m-d');
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
            ->line('Your ' . ucwords($this->subscription['subscription']->subscription_name) . ' subscription is due tomorrow!')
            ->line('The subscription is $' . number_format($this->subscription['subscription']->price, 2) . '.')
            ->action('Subsort', url('https://subsort.co'))
            ->line('If you would like to stop receiving notifications for this subscription, please visit Subsort.')
            ->line('Thank you for using our website!');
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
