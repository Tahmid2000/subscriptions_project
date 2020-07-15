<?php

namespace App\Http\Controllers;

use Acaronlex\LaravelCalendar\Calendar;

use App\Subscription;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
/* use Acaronlex\LaravelCalendar\Facades\Calendar; */

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $date = Carbon::now()->format('m/d/Y');
        return view('subscriptions.create', compact('date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = $this->validateSubscription();
        $subscription = Subscription::firstOrCreate([
            'user_id' => Auth::id(),
            'subscription_name' => strtolower(request('subscription_name')),
            'price' => request('price'),
            'first_date' => Carbon::create(request('first_date')),
            'next_date' => Carbon::create(request('first_date')),
            'period' => request('period'),
            'category' => request('category')
        ]);
        if ($subscription->first_date < Carbon::now()->addDays(-1))
            $this->updateNextDate($subscription);
        else
            $subscription->update([
                'next_date' => $subscription->first_date
            ]);
        request()->session()->flash('flash_message', 'Subscription added!');
        return redirect(route('home'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        return view('subscriptions.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validator = request()->validate([
            'subscription_name' => 'required|max:255',
            'price' => 'required:numeric',
            'first_date' => 'required|date',
            'period' => 'required'
        ]);
        $subscription->update([
            'price' => request('price'),
            'first_date' => Carbon::create(request('first_date')),
            'period' => request('period'),
            'category' => request('category')
        ]);
        if ($subscription->first_date < Carbon::now()->addDays(-1))
            $this->updateNextDate($subscription);
        else
            $subscription->update([
                'next_date' => $subscription->first_date
            ]);
        request()->session()->flash('flash_message', 'Subscription edited!');
        return redirect(route('home'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        request()->session()->flash('flash_message', ucwords($subscription->subscription_name) . ' Subscription deleted.');
        $subscription->delete();
        return redirect(route('home'));
    }

    public function thecalendar()
    {
        $events = Subscription::all()->where('user_id', Auth::user()->id);
        $event_list = [];
        foreach ($events as $event) {
            $event_list[] = Calendar::event(
                ucwords($event->subscription_name),
                true,
                Carbon::create($event->next_date),
                Carbon::create($event->next_date),
            );
            if ($event->period === 'Monthly') {
                $i = 1;
                while ($i < 60) {
                    $event_list[] = Calendar::event(
                        ucwords($event->subscription_name),
                        true,
                        Carbon::create($event->next_date)->addMonthsNoOverflow($i),
                        Carbon::create($event->next_date)->addMonthsNoOverflow($i),
                    );
                    $i += 1;
                }
            } else if ($event->period === 'Yearly') {
                $i = 1;
                while ($i < 5) {
                    $event_list[] = Calendar::event(
                        ucwords($event->subscription_name),
                        true,
                        Carbon::create($event->next_date)->addYearsNoOverflow($i),
                        Carbon::create($event->next_date)->addYearsNoOverflow($i),
                    );
                    $i += 1;
                }
            } else if ($event->period === 'Weekly') {
                $i = 1;
                while ($i < 260) {
                    $event_list[] = Calendar::event(
                        ucwords($event->subscription_name),
                        true,
                        Carbon::create($event->next_date)->addWeeks($i),
                        Carbon::create($event->next_date)->addWeeks($i),
                    );
                    $i += 1;
                }
            } else if ($event->period === 'Quarterly') {
                $i = 3;
                while ($i < 15) {
                    $event_list[] = Calendar::event(
                        ucwords($event->subscription_name),
                        true,
                        Carbon::create($event->next_date)->addMonthsNoOverflow($i),
                        Carbon::create($event->next_date)->addMonthsNoOverflow($i),
                    );
                    $i += 3;
                }
            }
        }
        $calendar = new Calendar();
        $calendar->addEvents($event_list);
        return view('subscriptions.calendar', compact('calendar'));
    }

    public function updateNextDate($subscription)
    {
        $new_date = $subscription->addNextDate();
        if ($new_date < Carbon::now()->addDays(-1)) {
            while ($new_date < Carbon::now()->addDays(-1)) {
                if ($subscription->period === 'Monthly')
                    $new_date = $new_date->addMonthNoOverflow();
                else if ($subscription->period === 'Yearly')
                    $new_date = $new_date->addYearNoOverflow();
                else if ($subscription->period === 'Weekly')
                    $new_date = $new_date->addWeek();
                else if ($subscription->period === 'Quarterly')
                    $new_date = $new_date->addMonthNoOverflow(3);
            }
        }
        $subscription->update([
            'next_date' => $new_date
        ]);
    }
    public function validateSubscription()
    {
        return request()->validate([
            'subscription_name' => [
                'required', 'max:255',
                function ($attribute, $value, $fail) {
                    $subs = Subscription::where('user_id', Auth::id());
                    if ($subs->where('subscription_name', $value)->first()) {
                        $fail('You already have this subscription added.');
                    }
                }
            ],
            'price' => 'required:numeric',
            'first_date' => 'required|date',
            'period' => 'required'
        ], $this->messages());
    }

    public function messages()
    {
        return [
            'subscription_name.required' => 'A subscription is required.',
            'price.required'  => 'A price is required.',
            'first_date.required' => 'An initial date is required.',
            'first_date.date_format' => "Inputted date doesn't match the format mm-dd-yyyy.",
            'period.required' => 'A frequency is required.'
        ];
    }
}
