<?php

namespace App\Console\Commands;

use App\Notifications\SubscriptionDue;
use Illuminate\Console\Command;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails when a subscription is due.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $to_update = Subscription::all()->where('next_date', '<', Carbon::now()->addDays(-1)->format('Y-m-d'));
        foreach ($to_update as $sub) {
            $new_date = $sub->addNextDate2();
            $sub->update([
                'next_date' => $new_date
            ]);
        }
        $users = User::all();
        foreach ($users as $user) {
            $subscriptions = Subscription::all()->where('user_id', $user->id)->where('next_date', Carbon::now()->addDay()->format('Y-m-d'))->where('allow_notifs', 1);
            foreach ($subscriptions as $sub) {
                if ($sub->next_date < Carbon::now()->addDays(-1)) {
                    $new_date = $sub->addNextDate2();
                    $sub->update([
                        'next_date' => $new_date
                    ]);
                }
                if (Carbon::parse($sub->next_date)->format('Y-m-d') === Carbon::now()->addDay()->format('Y-m-d')) {
                    $user->notifyAt(
                        new SubscriptionDue(['subscription' => $sub]),
                        Carbon::now()->addHours(11)
                    );
                } else {
                    $user->notifyAt(
                        new SubscriptionDue(['subscription' => $sub]),
                        Carbon::parse($sub->next_date)->addDays(-1)->addHours(11)
                    );
                }
            }
        }
    }
}
