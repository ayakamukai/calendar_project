@extends('calendars.template')
@section('title', 'Schedule編集')
@section('content')

<style type="text/css">
  .invalid-feedback{
    display: block;
  }
  
</style>

<body>

  <div class="container my-2 p-3 bg-white">
    <h3>スケジュール編集</h3>
    <div class="text-center">
        <h3 class="text-center">
        {{ $year }}年{{ $month }}月{{ $day }}日のスケジュール
        </h3>

        <form action="{{ route('update', $result->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
          <div class="form-group row">
            <label for="time" class="col-4 col-form-label">時間</label>
              <div class="col-2">
                <select class="form-control @if($errors->has('date_time')) is-invalid @endif" name="hour">
                  @for($i=0; $i<=23; $i++)
                    <option value={{ $i }}
                      @if(old('hour', $hour) == $i)
                        selected
                      @endif
                    >{{ $i }}</option>
                  @endfor
                </select>
              </div>
              <span>：</span>
              <div class="col-2">
                <select class="form-control @if($errors->has('date_time')) is-invalid @endif" name="minute">
                  @for($i=0; $i<=59; $i++)
                    @php
                      $y = str_pad($i, 2, 0, STR_PAD_LEFT);
                    @endphp
                      <option value={{ $y }}
                         @if(old('minute', $minute) == $y)
                           selected
                         @endif
                      >{{ $y }}</option>
                   @endfor
                </select>
              </div>
              @if ($errors->has('date_time'))
              <div class="invalid-feedback">
                {{ $errors->first('date_time') }}
              </div>
              @endif
          </div>

          <div class="form-group row">
            <label for="title" class="col-4 col-form-label">タイトル</label>
              <div class="col-6">
                <input type="text" class="form-control @if($errors->has('title')) is-invalid @endif" name="title" value="{{ old('title', $result->title) }}">
                  @if ($errors->has('title'))
                    <div class="invalid-feedback">
                      {{ $errors->first('title') }}
                    </div>
                  @endif
              </div>
          </div>

          <div class="form-group row">
            <div class="col-9 mx-auto">
              <textarea class="form-control @if($errors->has('plan')) is-invalid @endif" name="plan" rows="5">{{ old('plan', $result->plan) }}</textarea>
              @if ($errors->has('plan'))
                <div class="invalid-feedback">
                  {{ $errors->first('plan') }}
                </div>
              @endif
            </div>
          </div>

          <input type="hidden" class="form-control" name="date" value="{{ $date }}">
          
          <button class="btn btn-primary col-2" type="submit">更新する</button>
        </form>

      <div class="my-5">
      <a href="{{ route('schedule', ['schedule' => $date]) }}">戻る</a>
      </div>

    </div>
   </div>
</body>

@endsection
