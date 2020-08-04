@extends('calendars.template')
@section('title', 'Schedule編集')
@section('content')

<body>

  <div class="container my-2 p-3 bg-white">
    <h3>スケジュール編集</h3>
    <div class="text-center">
        <h3 class="text-center"><?php echo $year."年".$month."月".$day."日のスケジュール" ?></h3>
<?php
//未入力エラーメッセージ
session_start();
if(!empty($_SESSION['errMsg'])) {
  echo "<div class='alert alert-danger'>".$_SESSION['errMsg']."</div>";
}
session_destroy();
?>
        <form action="edit_register.php?schedule=<?= $schedule ?>&id=<?= $id ?>" method="post">

          <div class="form-group row">
            <label for="time" class="col-4 col-form-label">時間</label>
              <div class="col-2">
                <select class="form-control" name="hour">
                  <?php for($i=0; $i<=23; $i++){
                    echo '<option value="'.$i.'"';
                    if(ltrim($time_array[0], '0') == $i){ 
                      echo 'selected';
                      } 
                    echo '>'.$i.'</option>';
                  }?>
                </select>
              </div>
              <span>：</span>
              <div class="col-2">
                <select class="form-control" name="minute">
                <?php for($i=0; $i<=59; $i++){
                        $y = str_pad($i, 2, 0, STR_PAD_LEFT);
                        echo '<option value="'.$y.'"';
                        if($time_array[1] == $y){ 
                          echo 'selected';
                        } 
                        echo '>'.$y.'</option>';
                      }?>
                </select>
              </div>  
          </div>

          <div class="form-group row">
            <label for="title" class="col-4 col-form-label">タイトル</label>
              <div class="col-6">
                <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($results[0]['title']);?>">
              </div>
          </div>

          <div class="form-group row">
            <div class="col-9 mx-auto">
              <textarea class="form-control" name="plan" rows="5"><?php echo htmlspecialchars($results[0]['plan']);?></textarea>
            </div>
          </div>

          <button class="btn btn-primary col-2" type="submit">登録する</button>
        </form>

      <div class="my-5">
      <a href="schedule.php?schedule=<?= $schedule ?>">戻る</a>
      </div>

    </div>
   </div>
</body>

@endsection
