@extends('calendars.template')
@section('title', 'Schedule登録')
@section('content')

<body>

  <div class="container my-2 p-3 bg-white">
    <h3>スケジュール登録</h3>
    <div class="text-center">
        <h3 class="text-center">
          {{ $date_array[0] }}年{{ $date_array[1] }}月{{ $date_array[2] }}日のスケジュール
        </h3>
<?php
//未入力エラーメッセージ
session_start();
if(!empty($_SESSION['errMsg'])){
  echo "<div class='alert alert-danger'>".$_SESSION['errMsg']."</div>"; 
}
session_destroy();
?>
        <form action="{{ route('store') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group row">
          <label for="time" class="col-4 col-form-label">時間</label>
            <div class="col-2">
              <select class="form-control" name="hour">
                 @for($i=0; $i<=23; $i++)
                  <option value="{{ $i }}"
                  @if(!empty($_SESSION['input']['hour']) && $_SESSION['input']['hour'] == $i)
                    selected
                  @endif
                   >{{ $i }}</option>
                 @endfor
              </select>
            </div>
            <span>：</span>
            <div class="col-2">
              <select class="form-control" name="minute">
                @for($i=00; $i<=59; $i++)
                  @php 
                    $y = str_pad($i, 2, 0, STR_PAD_LEFT)
                  @endphp
                    <option value="{{ $y }}"
                  @if(!empty($_SESSION['input']['minute']) && $_SESSION['input']['minute'] == $y) 
                    selected
                  @endif
                  >{{ $y }}</option>
                @endfor
              </select>
            </div>  
        </div>

          <div class="form-group row">
            <label for="title" class="col-4 col-form-label">タイトル</label>
              <div class="col-6">
                <input type="text" class="form-control" name="title" value="<?php if(!empty($_SESSION['input']['title'])) {echo htmlspecialchars($_SESSION['input']['title']); } ?>">
              </div>
          </div>

          <div class="form-group row">
            <div class="col-9 mx-auto">
              <textarea class="form-control" name="plan" rows="5"><?php if(!empty($_SESSION['input']['plan'])) {echo htmlspecialchars($_SESSION['input']['plan']); } ?></textarea>
            </div>
          </div>

          <input type="hidden" class="form-control" name="date" value="{{ $date_array[0] }}-{{ $date_array[1] }}-{{ $date_array[2] }}">

          <button class="btn btn-primary col-2" type="submit">登録する</button>
        </form>

      <div class="my-5">
      <a href={{ route('schedule', ['schedule' => $date]) }}>戻る</a>
      </div>

    </div>
   </div>
</body>

@endsection
