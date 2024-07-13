<?php
// データベース接続設定
$dsn = 'mysql:dbname=データベース;host=localhost';
$user = 'ユーザー名';
$password = 'パスワード';

try {
    // PDOインスタンスを生成
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // 挿入するデータを準備
    $name = 'シャナ';
    $comment = 'うるさいうるさいうるさい';

    // SQL文を準備
    $sql = "INSERT INTO tbtest (name, comment) VALUES (:name, :comment)";
    $stmt = $pdo->prepare($sql);

    // プレースホルダに変数をバインド
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

    // 実行
    $stmt->execute();
} catch (PDOException $e) {
    
}

   
?>
