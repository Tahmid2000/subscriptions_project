<?php

namespace App\Http\Controllers;

use App\Charts\StatisticsChart;
use App\Statistics;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
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
        $raws = Subscription::where('user_id', Auth::id())->select('price', 'period', 'first_date', 'category')->get();
        $costMonth = $this->costMonthGraph($raws);
        $categoryChart = $this->categoryGraph($raws);
        $totalprices = 0;
        foreach ($raws as $raw) {
            $period = $raw['period'];
            $price = $raw['price'];
            if ($period === 'Monthly')
                $price = $price * 12;
            else if ($period === 'Weekly')
                $price = $price * 52;
            else if ($period === 'Quarterly')
                $price = $price * 4;
            else
                $price = $price;
            $totalprices += $price;
        }
        $totalpricestaxed = $totalprices * 1.0825;
        $totalprices = number_format($totalprices, 2);
        $totalpricestaxed = number_format($totalpricestaxed, 2);
        return view('statistics.index', compact('totalprices', 'totalpricestaxed', 'costMonth', 'categoryChart'));
    }

    public function costMonthGraph(Collection $raws)
    {
        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)",
            "rgba(119, 197, 57, 1.0)",
            "rgba(32, 199, 190, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.5)",
            "rgba(22,160,133, 0.5)",
            "rgba(255, 205, 86, 0.5)",
            "rgba(51,105,232, 0.5)",
            "rgba(244,67,54, 0.5)",
            "rgba(34,198,246, 0.5)",
            "rgba(153, 102, 255, 0.5)",
            "rgba(255, 159, 64, 0.5)",
            "rgba(233,30,99, 0.5)",
            "rgba(205,220,57, 0.5)",
            "rgba(119, 197, 57, 0.5)",
            "rgba(32, 199, 190, 0.5)"

        ];
        $months = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        foreach ($raws as $raw) {
            if ($raw['period'] === 'Monthly') {
                $price = $raw['price'];
                $months = array_map(function ($val) use ($price) {
                    return $val + $price;
                }, $months);
                if (Carbon::create($raw['first_date'])->year === Carbon::now()->year) {
                    $start_value = Carbon::create($raw['first_date'])->month;
                    $index = 0;
                    while ($index < $start_value - 1) {
                        $months[$index] -= $price;
                        $index++;
                    }
                }
            } else if ($raw['period'] === 'Yearly') {
                $month = Carbon::create($raw['first_date'])->month;
                $months[$month - 1] += $raw['price'];
            } else if ($raw['period'] === 'Weekly') {
                $daily_price = $raw['price'] / 7;
                foreach ($months as $key => $value) {
                    if ($key == 0 || $key == 2 || $key == 4 || $key == 6 || $key == 7 || $key == 9 || $key == 11) {
                        $months[$key] += $daily_price * 31;
                    } else if ($key == 3 || $key == 5 || $key == 8 || $key == 10) {
                        $months[$key] += $daily_price * 30;
                    } else {
                        if ($this->leapYear(Carbon::now()->year)) {
                            $months[$key] += $daily_price * 29;
                        } else {
                            $months[$key] += $daily_price * 28;
                        }
                    }
                }
            } else if ($raw['period'] === 'Quarterly') {
                $month = Carbon::create($raw['first_date'])->month;
                $index = $month - 1;
                while ($index < 12) {
                    $months[$index] += $raw['price'];
                    $index += 3;
                }
                if (Carbon::create($raw['first_date'])->year !== Carbon::now()->year) {
                    $index = $month - 4;
                    while ($index >= 0) {
                        $months[$index] += $raw['price'];
                        $index -= 3;
                    }
                }
            }
        }
        $months = array_map(function ($val) {
            return number_format($val, 2);
        }, $months);

        $costMonth = new StatisticsChart;
        $costMonth->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $costMonth->dataset('Cost/Month', 'bar', $months)
            ->color($borderColors)
            ->backgroundcolor($fillColors);
        return $costMonth;
    }

    protected function leapYear($year)
    {
        return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0)));
    }

    public function categoryGraph(Collection $raws)
    {
        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(153, 102, 255, .2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
        ];
        $data = [
            'entertainment' => 0,
            'services' => 0,
            'work' => 0,
            'personal' => 0,
            'other' => 0
        ];
        foreach ($raws as $raw) {
            $period = $raw['period'];
            $price = $raw['price'];
            if ($period === 'Monthly')
                $data[$raw['category']] += $price * 12 * 1.0825;
            else if ($period === 'Weekly')
                $data[$raw['category']] += $price * 52 * 1.0825;
            else if ($period === 'Quarterly')
                $data[$raw['category']] += $price * 4 * 1.0825;
            else
                $data[$raw['category']] += $price * 1.0825;
        }
        foreach ($data as $key => $value) {
            $data[$key] = number_format($value, 2);
        }
        $usersChart = new StatisticsChart;
        $usersChart->minimalist(true);
        $usersChart->labels(['Entertainment', 'Services', 'Work', 'Personal', 'Other']);
        $usersChart->dataset('Cost/Category', 'doughnut', [$data['entertainment'], $data['services'], $data['work'], $data['personal'], $data['other']])
            ->color($borderColors)
            ->backgroundcolor($fillColors);
        return $usersChart;
    }
}
