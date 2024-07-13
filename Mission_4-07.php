<?php
// データベース接続設定
$dsn = 'mysql:dbname=データベース;host=localhost';
$user = 'ユーザー名';
$password = 'データベース';

try {
    // PDOインスタンスを生成
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // 更新するデータを準備
    $name = 'ルルーシュ皇帝';
    $comment = 'オールハイルルルーシュ';
    $id = 1; 
    // SQL文を準備
    $sql = 'UPDATE tbtest SET name=:name, comment=:comment WHERE id=:id';
    $stmt = $pdo->prepare($sql);

    // プレースホルダに変数をバインド
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // 実行
    $stmt->execute();

  

    // 4-6のSELECTで表示させる機能
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();

    // ループして、取得したデータを表示
    foreach ($results as $row) {
        echo $row['id'] . ',';
        echo $row['name'] . ',';
        echo $row['comment'] . '<br>';
        echo "<hr>";
    }

} catch (PDOException $e) {
    
}
?>
