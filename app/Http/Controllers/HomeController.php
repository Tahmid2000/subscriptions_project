<?php

namespace App\Http\Controllers;

use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $subscriptions = Subscription::all()
            ->where('user_id', Auth::id());
        foreach ($subscriptions as $sub) {
            if ($sub->next_date < Carbon::now()) {
                $new_date = $sub->addNextDate2();
                $sub->update([
                    'next_date' => $new_date
                ]);
            }
        }
        return view('subscriptions.home', compact('subscriptions'));
    }
}
