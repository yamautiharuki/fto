<?php
// データベース接続設定
$dsn = 'mysql:dbname=データベース;host=localhost';
$user = 'ユーザー名';
$password = 'データベース';

try {
    // PDOインスタンスを生成
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // 削除するIDを指定
    $id = 8;

    // レコード削除のSQL文を準備
    $sql = 'DELETE FROM tbtest WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // 実行
    $stmt->execute();

    // データの表示
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
    // エラーが発生した場合の処理
   
}
?>