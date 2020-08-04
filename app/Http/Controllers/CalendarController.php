<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Http\Requests\CalendarRequest;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Schedule;

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

        $start = $year.'-'.$month.'-1';
        $end = $year.'-'.$month.'-31';
        $plan_date_dbs = Schedule::whereBetween('date', [$start, $end])->get();        

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
        'weeks' => $weeks, 'first_weekday' => $first_weekday, 'final_weekday' => $final_weekday, 'holidays' => $holidays, 'final_day' => $final_day, 'today' => $today, 'plan_date_dbs' => $plan_date_dbs]);
    }

    //スケジュール画面
    public function show(CalendarRequest $request)
    {

        $date_db = str_replace("/", "-", $request->query('schedule'));
        $date_array = explode('-', $date_db);

        var_dump($date_array);
        $results = Schedule::where('date', $date_db)->orderBy('time','asc')->get();
        return view('calendars.schedule', ['results' => $results, 'date_array' => $date_array, 'date_db' => $date_db]);
    
    }

    //登録
    public function create(CalendarRequest $request)
    {

        $date = $request->query('schedule');
        $date_array = explode('-', $date);
        var_dump($date_array);

        return view('calendars.create', ['date_array' => $date_array, 'date' => $date]);
    
    }

    //登録処理
    public function store(CalendarRequest $request)
    {

        // DB登録
        $results = new Schedule;
        $results->title = $request->title;
        $results->plan = $request->plan;
        $results->time = $request->hour.":".$request->minute;
        $results->date = $request->date;
        $results->save();

        return redirect()->route('calendar');
    }

    //編集
    public function edit($id)
    {
        $results = Schedule::find($id);
        var_dump($results->date);

        return view('calendars.edit', ['results' => $results]);
    }

    //更新処理
    public function update(CalendarRequest $request, $id)
    {
        // DBに更新
        //$results = User::find($id);
        //$results->fill($request->all());
        //$results->save();

        $results = Schedule::find($id);
        $results->title = $request->title;
        $results->plan = $request->plan;
        $results->time = $request->time;
        $results->date = $request->date;
        $results->save();
        return redirect()->route('schedule');
    }

    // ユーザー削除処理
    public function delete($id)
    {
        $results = Schedule::find($id);
        $results->delete();

        return redirect()->route('schedule');
    }


}
