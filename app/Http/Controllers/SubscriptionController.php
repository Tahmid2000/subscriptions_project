<?php

namespace App\Http\Controllers;

use Acaronlex\LaravelCalendar\Calendar;
use App\Notifications\SubscriptionDue;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

/* use Acaronlex\LaravelCalendar\Facades\Calendar; */

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subscription_name' => [
                'required', 'max:40',
                function ($attribute, $value, $fail) {
                    $subs = Subscription::where('user_id', Auth::id());
                    if ($subs->where('subscription_name', $value)->first()) {
                        $fail('You already have this subscription added.');
                    }
                }
            ],
            'price' => 'required|numeric',
            'first_date' => 'required|date',
            'period' => 'required'
        ], $this->messages());
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = json_decode($errors);
            return response()->json(['success' => FALSE, 'message' => $errors], 422);
        } else {
            $category = request('category');
            $allow_val = request('allow_notifs');
            if ($category == 'Select One') {
                $category = 'other';
            }
            if ($allow_val === NULL) {
                $allow_val = 0;
            }
            $subscription = Subscription::firstOrCreate([
                'user_id' => Auth::id(),
                'subscription_name' => strtolower(request('subscription_name')),
                'price' => request('price'),
                'first_date' => Carbon::create(request('first_date')),
                'next_date' => Carbon::create(request('first_date')),
                'period' => request('period'),
                'category' => $category,
                'allow_notifs' => $allow_val
            ]);
            if ($subscription->first_date < Carbon::now()->addDays(-1))
                $this->updateNextDate($subscription);
            else
                $subscription->update([
                    'next_date' => $subscription->first_date
                ]);
            if (Carbon::parse($subscription->next_date)->format('Y-m-d') === Carbon::now()->format('Y-m-d') && $allow_val === "1") {
                $user = User::find(Auth::id());
                $user->notifyAt(
                    new SubscriptionDue(['subscription' => $subscription]),
                    Carbon::now()->addMinute()
                );
            }
            request()->session()->flash('flash_message', 'Subscription added!');
            return response()->json(['success' => TRUE], 200);
        }
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
        $validator = Validator::make($request->all(), [
            'subscription_name' => 'required|max:40',
            'price' => 'required|numeric',
            'first_date' => 'required|date',
            'period' => 'required'
        ], $this->messages());
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = json_decode($errors);
            return response()->json(['success' => FALSE, 'message' => $errors], 422);
        } else {
            $user = User::find(Auth::id());
            $initial_date = Carbon::parse($subscription->first_date)->format('Y-m-d');
            $initial_allow = $subscription->allow_notifs;
            $category = request('category');
            $allow_val = request('allow_notifs');
            if ($category == 'Select One') {
                $category = 'other';
            }
            if ($allow_val === NULL) {
                $allow_val = 0;
            }
            $subscription->update([
                'price' => request('price'),
                'first_date' => Carbon::create(request('first_date')),
                'period' => request('period'),
                'category' => $category,
                'allow_notifs' => $allow_val
            ]);
            if ($subscription->first_date < Carbon::now()->addDays(-1))
                $this->updateNextDate($subscription);
            else
                $subscription->update([
                    'next_date' => $subscription->first_date
                ]);
            if ($initial_date !== Carbon::parse($subscription->first_date)->format('Y-m-d')) {
                $mail = true;
            } else
                $mail = false;
            if ($allow_val === "1") {
                if ($initial_allow == 0) {
                    $new_allow = true;
                } else {
                    $new_allow = false;
                }
            } else
                $new_allow = false;
            if (($mail === true || $new_allow === true) && (Carbon::parse($subscription->next_date)->format('Y-m-d') === Carbon::now()->format('Y-m-d')) && ($allow_val === "1")) {
                $user->notifyAt(
                    new SubscriptionDue(['subscription' => $subscription]),
                    Carbon::now()->addMinute()
                );
            }
            request()->session()->flash('flash_message', 'Subscription edited!');
            return response()->json(['success' => TRUE], 200);
        }
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

    public function messages()
    {
        return [
            'subscription_name.required' => 'A subscription name is required.',
            'price.required'  => 'A price is required.',
            'first_date.required' => 'An initial date is required.',
            'period.required' => 'A frequency is required.'
        ];
    }
}
