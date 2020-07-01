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
        if (request('sort')) {
            if (request('sort') === 'order') {
                $subscriptions = $subscriptions;
            } else if (request('sort') === 'upcoming') {
                $subscriptions = $subscriptions->sortBy('next_date');
            } else if (request('sort') === 'most_expensive') {
                $subscriptions = $subscriptions->sortByDesc('price');
            } else if (request('sort') === 'least_expensive') {
                $subscriptions = $subscriptions->sortBy('price');
            } else {
                $temp = $subscriptions;
                $subscriptions = $subscriptions->where('category', request('sort'));
                if (count($subscriptions) === 0) {
                    $subscriptions = $temp;
                    request()->session()->flash('flash_message', 'No subscriptions with this category.');
                } else {
                    request()->session()->flash('flash_message', ucwords(request('sort')) . ' subscriptions!');
                }
            }
        }
        $sorted = request('sort');
        return view('subscriptions.home', compact('subscriptions', 'sorted'));
    }
}
