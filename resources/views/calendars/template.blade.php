<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>  @yield('title')</title>
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

@yield('content')

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script>
    $("[data-toggle='tooltip']").tooltip()
  </script>
</body>
</html>