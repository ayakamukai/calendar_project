@extends('calendars.template')
@section('title', 'Schedule')
@section('content')

<body>

<div class="container my-2 p-3 bg-white">
  <h3>スケジュール</h3>
  <div class="text-center">
    <h3 class="text-center">
      {{ $year }}年{{ $month }}月{{ $day }}日のスケジュール
    </h3>
    <div class="my-2">
      <a href="{{ route('create', ['schedule' => $date]) }}">登録</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
    @endif

    @if(count($results) > 0 )
      <table class="table table-bordered text-center">
        <tr>
          <th>時間</th>
          <th>タイトル</th>
          <th></th>
          <th></th>
        </tr>
        <tr>
        @foreach($results as $result)
          <td>{{ $result->time->format('G:i') }}</td>
          <td align="left">{{ $result->title }}</td>
          <td><a href="{{ route('edit', ['id' => $result->id]) }}">編集</a></td>
          <td><a href="{{ route('delete', ['id' => $result->id]) }}" class="delete">削除</a></td>
        </tr>
        @endforeach
     </table>
    @else
      <h5 style="line-height:500%;">予定がありません</h5>
    @endif

    <div class="my-2">
      <a href="{{ route('calendar', ['month' => $month, 'year'=> $year]) }}">戻る</a>
    </div>

<script>
//キャンセルの時の処理
$('.delete').click(function(){
    if(!confirm('本当に削除しますか？')){
        return false;
    }
});
</script>

@endsection
