<?php
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$password = 'パスワード';

try {
    // PDOインスタンスを生成
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    // テーブル作成のSQL文
    $sql = "CREATE TABLE IF NOT EXISTS tbtest25252 (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name CHAR(32),
                comment TEXT
            );";
    
    // SQL文を実行
    $stmt = $pdo->query($sql);
   }  catch (PDOException $e) 
 {
}
?>

