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
            $year = date('Y');
        }
        if($request->query('month')){
            $month = $request->query('month');
        }else{
            $month = date('n');
        }

        $weeks = ['日','月','火','水','木','金','土'];
        $today = Carbon::today()->format('Y-m-d'); //今日
        $first_weekday = Carbon::create($year, $month, 1, 0,0,0)->format('w');  //初日の曜日
        $final_weekday = Carbon::create($year, $month+1, 0, 0,0,0)->format('w');  //月末日の曜日
        $last_day = Carbon::create($year, $month+1, 0, 0,0,0)->format('j'); //任意の月の末日

        $last_month = Carbon::create($year, $month-1, 1, 0,0,0)->format('n');
        $next_month = Carbon::create($year, $month+1, 1, 0,0,0)->format('n');
        $last_month_year = Carbon::create($year, $month-1, 1, 0,0,0)->format('Y');
        $next_month_year = Carbon::create($year, $month+1, 1, 0,0,0)->format('Y');

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
            return view('welcome');
        }

        return view('calendars.calendar', ['year' => $year, 'month' => $month, 'last_month' => $last_month, 'last_month_year' => $last_month_year, 'next_month' => $next_month, 'next_month_year' => $next_month_year,
        'weeks' => $weeks, 'first_weekday' => $first_weekday, 'final_weekday' => $final_weekday, 'holidays' => $holidays, 'last_day' => $last_day, 'today' => $today]);
    }
}
