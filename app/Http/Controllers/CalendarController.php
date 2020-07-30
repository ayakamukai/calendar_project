<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Http\Requests\CalendarRequest;

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

        $today = date("j"); // 現在の日 
        $weeks = ['日','月','火','水','木','金','土'];
        $first_weekday = date("w", mktime(0,0,0, $month, 1, $year)); //初日の曜日
        $final_weekday = date("w", mktime(0,0,0, $month+1, 0, $year)); //月末日の曜日
        $last_day = date("j", mktime(0,0,0, $month+1, 0, $year)); //任意の月の末日

        $last_month = date('n', mktime(0, 0, 0, $month-1, 1, $year));
        $next_month = date('n', mktime(0, 0, 0, $month+1, 1, $year));
        $last_month_year = date('Y', mktime(0, 0, 0, $month-1, 1, $year));
        $next_month_year = date('Y', mktime(0, 0, 0, $month+1, 1, $year));

        try {
            //ファイルの読み込み
            $file = new \SplFileObject(storage_path('app/public/syukujitsu.csv'));
            $file->setFlags(
                \SplFileObject::READ_CSV     |
                \SplFileObject::READ_AHEAD   |
                \SplFileObject::SKIP_EMPTY   |
                \SplFileObject::DROP_NEW_LINE
            );

            $holidays = [];
            foreach($file as $line){
                $lines = mb_convert_encoding($line, 'UTF-8', 'SJIS');
                $holidays[$lines[0]] = $lines[1]; //(日付=>祝日)の連想配列
            }
            // var_dump($holidays);

            } catch (PDOException $e) {
            echo $e->getMessage();
            }

        return view('calendars.calendar', ['year' => $year, 'month' => $month, 'last_month' => $last_month, 'last_month_year' => $last_month_year, 'next_month' => $next_month, 'next_month_year' => $next_month_year,
        'weeks' => $weeks, 'first_weekday' => $first_weekday, 'final_weekday' => $final_weekday, 'holidays' => $holidays, 'last_day' => $last_day, 'today' => $today]);
    }
}
