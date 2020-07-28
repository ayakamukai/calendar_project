<?php

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

//DB接続
try {
  $dbh = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
    ]
      );
  // if ($dbh == null){
  //   echo '接続に失敗しました。<br>';
  // }else{
  //   echo '接続に成功しました。<br>';
  // }

  //データ検索範囲
  $start = $year.'-'.$month.'-1';
  $end = $year.'-'.$month.'-31';
  
  $sql = 'select date from calendars where date between ? and ? order by date asc';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(1,$start);
  $stmt->bindValue(2,$end);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}

$plan_date_db = [];
foreach ($results as $result) {
$plan_date_db[] = $result['date']; //日付のみの配列
}
