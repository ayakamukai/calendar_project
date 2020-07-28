<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Calendar</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <style type="text/css">
    body {
      background-color: #FFF;
    }
    th {
      background-color: #FFFFCC;
    }
    .sunday, td.sunday a{
        color: red;
    }
    .saturday, td.saturday a{
      color: blue;
    }
    td.holiday a{
      color: red;
    }
    a{
      color: #000;
    }
    .today {
      background: #99FFFF;
    }
    .left {
      text-align: left;
    }
    .center {
      text-align: center;
    }
    .right {
      text-align: right;
    }
    .has_plan {
      font-weight: 700;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="my-2 p-3 bg-white">
      <h3>カレンダー</h3>
      <h3 class="text-center"><?php echo $year."年".$month."月" ?></h3>
          <div class="row">
            <div class="col left">
              <a href="?month=<?php echo $last_month?>&year=<?= $last_month_year ?>">＜＜<?= $last_month ?>月</a>
            </div>
            <div class="col center">
              <a href="/">今月</a>
            </div>
            <div class="col right">
              <a href="?month=<?php echo $next_month ?>&year=<?= $next_month_year ?>"><?= $next_month ?>月＞＞</a>
            </div>
          </div>
      <table class="table table-bordered text-center">
        <tr>
  <?php
            foreach($weeks as $week){
              if($week == $weeks[0]){
                echo'<th class ="sunday">'.$weeks[0];
              }elseif($week == $weeks[6]){
                echo'<th class ="saturday">'.$weeks[6];
              }else{
                echo '<th>'.$week;
              }
              echo '</th>';
            }
  ?>
        </tr>
  <?php
          //最初の空白
          if(!$first_weekday ==0 ){
              echo '<tr>';
            for($y=1; $y<=$first_weekday; $y++){
              echo '<td></td>';
            }
          }
          //日付繰り返し
          for($i=1; $i<=$last_day; $i++){
            $day_of_week = date("w", mktime(0,0,0, $month, $i, $year)); //$i日の曜日
            $date = date('Y/n/j', mktime(0,0,0, $month, $i, $year)); //$year/$month/$i
            $date_db = date('Y-m-d', mktime(0,0,0, $month, $i, $year)); //$year-$month-$i

              if($day_of_week == 0){ //週始め
                echo '<tr>';
              }

              if($day_of_week == 0){ //cssクラス設定
                $css_class = "'sunday";
              }elseif($day_of_week == 6){
                $css_class = "'saturday";
              }else{
                $css_class = "'weekday";
              }

              if($i == $today && $month == date('n') && $year == date('Y')) { //今日のcss
                $css_class = $css_class." today";
              }

              //予定の有無
              // if (in_array($date_db, $plan_date_db)) {
              //   $css_class = $css_class." has_plan";
              // }

              if(isset($holidays[$date])){ //祝日名
              echo "<td class=".$css_class." holiday' data-toggle='tooltip' title='".$holidays[$date]."'><a href='schedule.php?schedule=".$date."'>".$i."</a></td>";
              }else{
              echo "<td class=".$css_class."'><a href='schedule.php?schedule=".$date."'>".$i."</a></td>"; //日終わり
              }

              if($day_of_week == 6){ //週末折り返し
              echo '</tr>';
              }

              if($i == $last_day){
              for($x=1; $x<=(6-$final_weekday); $x++){
                echo '<td></td>'; //最後の空白
              }
              }
          }
          //最後の閉じ
          if($final_weekday == 6){
              echo '';
          }else{
              echo '</tr>';
          }
  ?>
      </table>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script>
    $("[data-toggle='tooltip']").tooltip()
  </script>
</body>
</html>