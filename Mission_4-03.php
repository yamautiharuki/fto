<?php
// データベース接続設定
$dsn = 'mysql:dbname=データベース;host=localhost';
$user = 'ユーザー名';
$password = 'パスワード';

try {
    // PDOインスタンスを生成
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // SQL文を準備
    $sql = 'SHOW TABLES';
    
    // SQLを実行してテーブル名を取得
    $result = $pdo->query($sql);

    // 取得したテーブル名を表示・複数テーブルがあれば複数表示される
    foreach ($result as $row) {
        echo $row[0] . '<br>';
    }
    echo "<hr>";

} catch (PDOException $e) {
   
}
?>
