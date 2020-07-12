<?php

// var_dump($_GET);
// exit();

// データの取り出し
$todo = $_GET['todo'];
$deadline = $_GET['deadline'];

// 書き込みデータ
$write_date = "{$deadline} {$todo}\n";

// ファイルを開く
$file = fopen('date/todo.csv','a');

// ファイルをロック
flock($file, LOCK_EX);

// ファイル書き込み処理
fwrite($file,$write_date);

// ファイルをアンロック
flock($file,LOCK_UN);

// ファイルを閉じる
fclose($file);

// 入力画面へ移動
header('Location:index.php');

// 入力チェック
if(
    !isset($_GET['task']) || $_GET['task'] == '' ||
    !isset($_GET['deadline']) || $_GET['deadline'] == ''
) {
    exit('ParamError'); 
}

exit('OK!');

// 受け取ったデータを変数に入れる
 $todo = $_GET['todo'];
 $deadline = $_GET['deadline'];

// DBの接続
$dbn = 'mysql:dbname=gsacf_l03_07;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
    $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
    // DB接続に失敗した場合はここでエラーを出力し、以降の処理を中止する
    echo json_encode(["db error" => "{$e->getMessage()}"]);
    exit();
}
                 
// データ登録sql
$sql = 'INSERT INTO kadai_table(id, todo, deadline, created_at, updated_at)
VALUES(NULL, :todo, :deadline, sysdate(), sysdate())';

// sql準備
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$status = $stmt->execute();

// 失敗時にエラーを出力し，成功時は登録画面に戻る
if ($status == false) {
    $error = $stmt->errorInfo();
    // データ登録失敗次にエラーを表示
    exit('sqlError:' . $error[2]);
} else {
    // 登録ページへ移動
    header('Location:index.php');

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo表示画面（GET）</title>
</head>

<body>
    <fieldset>
        <legend>todo表示画面（GET）</legend>
        <table>
            <thead>
                <tr>
                    <th>todo</th>
                    <th>deadline</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $todo ?></td>
                    <td><?= $deadline ?></td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</body>

</html>