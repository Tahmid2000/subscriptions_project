<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Subscription;
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
    protected $description = 'Send emails';

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
        $subscriptions = Subscription::all();
        foreach ($subscriptions as $sub) {
            $date = date('m/d/Y', strtotime($sub->next_date));
            Mail::send('Html.view', ['date' => $date], function ($message) {
                $message->from('subsort@subsort.com', 'Subsort');
                $message->to('tahmidimran1@gmail.com', 'Tahmid Imran');
                $message->subject('Subscription Due');
            });
        }
    }
}
