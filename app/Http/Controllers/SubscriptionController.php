<?php

namespace App\Http\Controllers;

use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
        $date = Carbon::now()->format('m-d-Y');
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
            'subscription_name' => request('subscription_name'),
            'price' => request('price'),
            'first_date' => Carbon::createFromFormat('m-d-Y', request('first_date')),
        ]);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }

    public function validateSubscription()
    {
        return request()->validate([
            'subscription_name' => 'required|max:255',
            'price' => 'required',
            'first_date' => 'required|date_format:m-d-Y',
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
