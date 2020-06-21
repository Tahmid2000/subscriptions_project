<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['subscription_name', 'price', 'first_date', 'period'];

    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
