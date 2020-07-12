<?php

// ファイル読み込み操作
$str = '';

// ファイルを開く処理
$file = fopen('date/todo.csv', 'r');

// ファイルロックの処理
flock($file, LOCK_EX);

// ファイル書き込み処理

//1行ずつ取り出す 
if($file){
    while($line = fgets($file)){
        $str .= "<tr><td>{$line}</td></tr>";
    }
}

// ファイルアンロックの処理
flock($file, LOCK_UN);


// ファイルを閉じる
fclose($file);






?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>スイカの予約リスト</title>
</head>

<body>
  <fieldset>
    <legend>スイカの予約リスト</legend>
    <a href="index.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>予約</th>
        </tr>
      </thead>
      <tbody>
        <?= $str ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>


