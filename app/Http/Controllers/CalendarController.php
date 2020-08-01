<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Http\Requests\CalendarRequest;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CalendarController extends Controller
{
    //カレンダー画面
    public function index(CalendarRequest $request)
    {
        // 任意の年月
        if($request->query('year')){
            $year = $request->query('year');
        }else{
            $year = Carbon::now()->year;
        }
        if($request->query('month')){
            $month = $request->query('month');
        }else{
            $month = Carbon::now()->month;
        }

        $weeks = ['日','月','火','水','木','金','土'];
        $carbon = Carbon::create($year, $month, 1, 0,0,0);
        
        $today = $carbon->today()->toDateString(); //今日
        $first_weekday = $carbon->copy()->firstOfMonth()->dayOfWeek;  //初日の曜日
        $final_weekday = $carbon->copy()->lastOfMonth()->dayOfWeek;  //月末日の曜日
        $final_day = $carbon->copy()->lastOfMonth()->format('j'); //任意の月の末日

        $last_month = $carbon->copy()->subMonth()->format('n');;
        $last_month_year = $carbon->copy()->subMonth()->format('Y');;
        $next_month = $carbon->copy()->addMonth()->format('n');;
        $next_month_year =  $carbon->copy()->addMonth()->format('Y');;

        $holidays = [];
        try {
            //ファイルの読み込み
            $csv = Storage::get('syukujitsu.csv');
            $file = explode("\n", $csv);
            $lines = mb_convert_encoding($file, 'UTF-8', 'SJIS'); 

            foreach($lines as $line){
              $holiday = explode(",", $line);
              if(!empty($holiday[0]) && !empty($holiday[1])){
                $holidays[$holiday[0]] = $holiday[1];  //(日付=>祝日)の連想配列
              }
            }

        } catch (Exception $e) {
            echo "※祝日データが取得できませんでした";
        }

        return view('calendars.calendar', ['year' => $year, 'month' => $month, 'last_month' => $last_month, 'last_month_year' => $last_month_year, 'next_month' => $next_month, 'next_month_year' => $next_month_year,
        'weeks' => $weeks, 'first_weekday' => $first_weekday, 'final_weekday' => $final_weekday, 'holidays' => $holidays, 'final_day' => $final_day, 'today' => $today]);
    }
}
