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
      <a href="{{ route('create', ['schedule' => $date]) }}">登録</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
    @endif

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
          <td><a href="{{ route('delete', ['id' => $result->id]) }}">削除</a></td>
        </tr>
        @endforeach
     </table>

    <div class="error text-alart">
      @error('ID')
        <strong class="text-danger">※{{ $message }}</strong>
      @enderror
    </div>  


    <div class="my-2">
      <a href="{{ route('calendar', ['month' => $date_array[1], 'year'=> $date_array[0]]) }}">戻る</a>
    </div>

@endsection
