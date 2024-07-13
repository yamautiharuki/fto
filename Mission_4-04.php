<?php
// データベース接続設定
$dsn = 'mysql:dbname=データベース;host=localhost';
$user = 'ユーザー名';
$password = 'パスワード';

try {
    // PDOインスタンスを生成
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // SQL文を準備
    $sql = 'SHOW CREATE TABLE tbtest';
    
    // SQLを実行してCREATE文を取得
    $result = $pdo->query($sql);

    // 取得したCREATE文を表示
    foreach ($result as $row) {
        echo $row[1]; // CREATE文は結果セットの2番目のカラムにある
    }
    echo "<hr>";

} catch (PDOException $e) {
  
}
?>
