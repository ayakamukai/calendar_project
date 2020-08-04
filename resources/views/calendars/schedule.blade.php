@extends('calendars.template')
@section('title', 'Schedule')
@section('content')

<body>

<div class="container my-2 p-3 bg-white">
  <h3>スケジュール</h3>
  <div class="text-center">
    <h3 class="text-center">
      {{ $date_array[0] }}年{{ $date_array[1] }}月{{ $date_array[2] }}日のスケジュール
    </h3>
    <div class="my-2">
      <a href="{{ route('create', ['schedule' => $date_db]) }}">登録</a>
    </div>

<?php
session_start();
//登録メッセージ表示
if(!empty($_SESSION['update'])){
echo "<div class='alert alert-success'>".$_SESSION['update']."</div>";
}
if(!empty($_SESSION['register'])){
echo "<div class='alert alert-success'>".$_SESSION['register']."</div>";
}
//削除メッセージ表示
if(!empty($_SESSION['delete'])){
echo "<div class='alert alert-success'>".$_SESSION['delete']."</div>";
}
session_destroy();
?>

    @if(empty($results))
      <h5 style="line-height:500%;">予定がありません</h5>
    @else
      <table class="table table-bordered text-center">
        <tr>
          <th>時間</th>
          <th>タイトル</th>
          <th></th>
          <th></th>
        </tr>
      @foreach($results as $result)
        {{ $result->id }}
        {{ $result->date }}
        {{ $result->title }}
        {{ $result->plan }}
        <tr>
          <td>{{ $result->time }}</td>
          <td align="left">{{ $result->title }}</td>
          <td><a href="{{ route('edit', ['id' => $result->id]) }}">編集</a></td>
          <td><a href="{{ route('delete', ['id' => $result->id]) }}">削除</a></td>
      @endforeach
        </tr>
    </table>
    @endif


    <div class="my-2">
      <a href="{{ route('calendar', ['month' => $date_array[1], 'year'=> $date_array[0]]) }}">戻る</a>
    </div>

@endsection
