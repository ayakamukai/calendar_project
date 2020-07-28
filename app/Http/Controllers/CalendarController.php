<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class CalendarController extends Controller
{
    //カレンダー画面
    public function index()
    {
        
        //任意の年月と正規表現チェック
        if(isset($_GET['year']) && preg_match('/^[0-9]{4}$/', $_GET['year'])){
            $year = $_GET['year'];
        }else{
            $year = date('Y');
        }
        
        if(isset($_GET['month']) && preg_match('/^[0-9]{1,2}$/', $_GET['month'])){
            $month =  $_GET['month']; 
        }else{
            $month = date('n');
        }
        //日付チェック
        if(!(checkdate($month, 1, $year))){
            header('Location: calendar.php');
            exit;
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
            // ファイルの読み込み
            $file = new \SplFileObject(storage_path('app/public/syukujitsu.csv'));
            
            $file->setFlags(\SplFileObject::READ_CSV);           // CSV 列として行を読み込む
            //   \SplFileObject::READ_AHEAD       // 先読み/巻き戻しで読み出す。
            // //   \SplFileObject::SKIP_EMPTY |         // 空行は読み飛ばす
            // //   \SplFileObject::DROP_NEW_LINE    // 行末の改行を読み飛ばす

            $csv = mb_convert_encoding($file, 'UTF-8', 'SJIS');
            var_dump($csv);
            $lines = explode("\n", $csv);  //改行で分割 (1=>日付,祝日)の配列
            echo "<br>";
            var_dump($lines);
            $holidays = [];
            // foreach ($lines as $line) {
            // $holiday = explode(",", $line); //カンマで分割 (1=>祝日,2=>祝日)の配列s
            // $holidays[$holiday[0]] = $holiday[1]; //(日付=>祝日)の連想配列
            // }
            // var_dump($holidays);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return view('calendars.calendar', ['year' => $year, 'month' => $month, 'last_month' => $last_month, 'last_month_year' => $last_month_year, 'next_month' => $next_month, 'next_month_year' => $next_month_year,
        'weeks' => $weeks, 'first_weekday' => $first_weekday, 'final_weekday' => $final_weekday, 'holidays' => $holidays, 'last_day' => $last_day, 'today' => $today]);
    }
}
