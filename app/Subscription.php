<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = ['subscription_name', 'price', 'first_date', 'next_date', 'period', 'user_id'];
    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addNextDate()
    {
        if ($this->period === 'Monthly') {
            return $this->first_date->addMonthNoOverflow();
        } else if ($this->period === 'Yearly') {
            return $this->first_date->addYearNoOverflow();
        } else if ($this->period === 'Weekly') {
            return $this->first_date->addWeek();
        } else if ($this->period === 'Quarterly') {
            return $this->first_date->addMonthNoOverflow(3);
        }
        return NIL;
    }

    public function addNextDate2()
    {
        if ($this->period === 'Monthly') {
            return Carbon::create($this->next_date)->addMonthNoOverflow();
        } else if ($this->period === 'Yearly') {
            return Carbon::create($this->next_date)->addYearNoOverflow();
        } else if ($this->period === 'Weekly') {
            return Carbon::create($this->next_date)->addWeek();
        } else if ($this->period === 'Quarterly') {
            return Carbon::create($this->next_date)->addMonthNoOverflow(3);
        }
        return NIL;
    }
}
