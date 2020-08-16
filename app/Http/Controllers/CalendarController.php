<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CalendarRequest;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Schedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CalendarController extends Controller
{
    //カレンダー画面
    public function index(Request $request)
    {
        // 任意の年月
        if($request->query('year') && preg_match('/^[0-9]{4}$/', $request->query('year'))){
            $year = $request->query('year');
        }else{
            $year = Carbon::now()->year;
        }

        if($request->query('month') && preg_match('/^[0-9]{1,2}$/', $request->query('month'))){
            $month = $request->query('month');
        }else{
            $month = Carbon::now()->month;
        }

        //日付チェック
        if(!(checkdate($month, 1, $year))){
            return redirect()->route('calendar');
        }

        //一か月毎の予定取得
        $start = $year.'-'.$month.'-1';
        $end = $year.'-'.$month.'-31';
        $items = Schedule::whereBetween('date', [$start, $end])->get();
        $month_plans = [];
        foreach($items as $item){
            $month_plans[] = $item->date->format('Y-n-j');
        }

        $weeks = ['日','月','火','水','木','金','土'];
        $carbon = Carbon::create($year, $month, 1, 0,0,0);

        $today = $carbon->today()->format('Y-n-j'); //今日
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
            $array = explode("\n", $csv);
            $file = mb_convert_encoding($array, 'UTF-8', 'SJIS'); 
            $lines = str_replace("/", "-", $file);

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
        'weeks' => $weeks, 'first_weekday' => $first_weekday, 'final_weekday' => $final_weekday, 'holidays' => $holidays, 'final_day' => $final_day, 'today' => $today, 'month_plans' => $month_plans]);
    }

    //スケジュール画面
    public function show(Request $request)
    {

        $date = $request->query('schedule');
        $date_array = explode('-', $date);

        //日付チェック
        if(count(array_filter($date_array)) == 3){
          $year = $date_array[0];
          $month = $date_array[1];
          $day = $date_array[2];

          if(!(is_numeric($year)) || !(is_numeric($month)) || !(is_numeric($day)) || !(checkdate($month, $day, $year))){
            return redirect()->route('calendar');
          }
        }else{
            return redirect()->route('calendar');
        }

        $results = Schedule::where('date', $date)->orderBy('time','asc')->get();

       return view('calendars.schedule', ['results' => $results, 'date_array' => $date_array, 'date' => $date]);
    }

    //登録画面
    public function create(Request $request)
    {
        $date = $request->query('schedule');
        $date_array = explode('-', $date);

        //日付チェック
        if(count(array_filter($date_array)) == 3){
          $year = $date_array[0];
          $month = $date_array[1];
          $day = $date_array[2];
  
          if(!(is_numeric($year)) || !(is_numeric($month)) || !(is_numeric($day)) || !(checkdate($month, $day, $year))){
            return redirect()->route('calendar');
          }
        }else{
          return redirect()->route('calendar');
        }

        return view('calendars.create', ['date_array' => $date_array, 'date' => $date]);
    }

    //登録処理
    public function store(CalendarRequest $request)
    {
        //DB登録
        $results = new Schedule;
        $results->title = $request->title;
        $results->plan = $request->plan;
        $results->time = $request->hour.":".$request->minute;
        $results->date = $request->date;
        $results->save();
        $date = $results->date->format('Y-n-j');
        $date_array = explode('-', $date);

        return redirect()->route('schedule', ['schedule' => $date, 'date_array' => $date_array])->with('status', '予定を登録しました！');
    }

    //編集
    public function edit(Request $request,  int $id)
    {
        try {
            $result = Schedule::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('calendar')->withErrors(['ID' => '指定した予定が存在しません']);
        }
        $date = $result->date->format('Y-n-j');
        $date_array = explode('-', $date);
        $hour = $result->time->format('G');
        $minute = $result->time->format('i');

          return view('calendars.edit', ['result' => $result, 'date' => $date, 'date_array' => $date_array, 'hour' => $hour, 'minute' => $minute]);
    }

    //更新処理
    public function update(CalendarRequest $request, $id)
    {
        try {
            $result = Schedule::findOrFail($id);
        } catch (ModelNotFoundException $e) {   
            return redirect()->route('calendar')->withErrors(['ID' => '指定した予定が存在しません']);
        }
        $date = $result->date->format('Y-n-j');
        $result->title = $request->title;
        $result->plan = $request->plan;
        $result->time = $request->hour.":".$request->minute;
        $result->date = $request->date;
        $result->save();

        return redirect()->route('schedule', ['schedule' => $date])->with('status', '予定を更新しました！');
    }

    // 削除処理
    public function delete(Request $request, int $id)
    {
        try {
            $result = Schedule::findOrFail($id);
            $date = $result->date->format('Y-n-j');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('calendar')->withErrors(['ID' => '指定した予定が存在しません']);
          }
            $result->delete();
          return redirect()->route('schedule', ['schedule' => $date])->with('status', '予定を消去しました！');
        }
}
