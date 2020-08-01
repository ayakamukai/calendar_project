@extends('calendars.template')
@section('title', 'Calendar')
@section('content')

<body>

  <div class="container">
    <div class="my-2 p-3 bg-white">
      <h3>カレンダー</h3>
      <h3 class="text-center">{{ $year }}年{{ $month }}月</h3>
          <div class="row">
            <div class="col left">
              <a href={{ route('calendar', ['month' => $last_month, 'year' => $last_month_year]) }}>＜＜{{ $last_month }}月</a>
            </div>
            <div class="col center">
              <a href="/">今月</a>
            </div>
            <div class="col right">
              <a href={{ route('calendar', ['month' => $next_month, 'year' => $next_month_year]) }}>{{ $next_month }}月＞＞</a>
            </div>
          </div>
      <table class="table table-bordered text-center">
        <tr>
            @foreach ($weeks as $week)
              @if($week == $weeks[0])
                <th class ="sunday">{{ $weeks[0] }}
              @elseif($week == $weeks[6])
                <th class ="saturday">{{ $weeks[6] }}
              @else
                <th>{{ $week }}
              @endif
                </th>
            @endforeach
        </tr>

          <!-- 最初の空白 -->
          @if(!$first_weekday == 0 )
              <tr>
            @for($y=1; $y<=$first_weekday; $y++)
              <td></td>
            @endfor
          @endif

          <!-- 日付繰り返し -->
          @for($i=1; $i<=$final_day; $i++)
            @php
              $carbon = \Carbon\Carbon::create($year, $month, $i, 0,0,0);
              $day_of_week = $carbon->copy()->dayOfWeek;  //<!-- $i日の曜日 -->
              $date = $carbon->copy()->format('Y/n/j');  //<!-- $year/$month/$i -->
              $date_db = $carbon->copy()->format('Y-m-d');  //<!--$year-$month-$i -->
            @endphp

            <!-- 週始め -->
            @if($day_of_week == 0)
              <tr>
            @endif

            <!-- cssクラス設定  -->
            @php
              if($day_of_week == 0){
                $css_class = "sunday";
              }elseif($day_of_week == 6){;
                $css_class = "saturday";
              }else{
                $css_class = "weekday";
              }

              if($date_db == $today){
                $css_class = $css_class." today";
              }
            @endphp

              <!-- //予定の有無
              // if (in_array($date_db, $plan_date_db)) {
              //   $css_class = $css_class." has_plan";
              // } -->

              <!-- 祝日名 -->
              @if(isset($holidays[$date]))
                <td class="{{ $css_class }} holiday" data-toggle="tooltip" title="{{ $holidays[$date] }}"><a href="">{{ $i }}</a></td>
              @else
                <td class="{{ $css_class }}"><a href="">{{ $i }}</a></td>  <!-- 日終わり -->
              @endif

              <!-- 週末折り返し -->
              @if($day_of_week == 6)
                </tr>
              @endif

              <!-- //最後の空白 -->
              @if($i == $final_day)
                @for($x=1; $x<=(6-$final_weekday); $x++)
                  <td></td>  
                @endfor
              @endif

          @endfor

          <!-- 最後の閉じ -->
          @if($final_weekday == 6)
          @else
            </tr>
          @endif
      </table>
    </div>
  </div>

@endsection
