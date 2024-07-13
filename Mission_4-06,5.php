<?php
// データベース接続設定
$dsn = 'mysql:dbname=データベース;host=localhost';
$user = 'ユーザー名';
$password = 'データベース';

try {
    // PDOインスタンスを生成
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // 挿入するデータを準備
    $name = 'めぐみん';
    $comment = 'エクスプロージョン';

    // SQL文を準備
    $sql = "INSERT INTO tbtest (name, comment) VALUES (:name, :comment)";
    $stmt = $pdo->prepare($sql);

    // プレースホルダに変数をバインド
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

    // 実行
    $stmt->execute();

    // 挿入されたレコードのIDを取得
    $lastId = $pdo->lastInsertId();

    // 挿入されたレコードのIDを2に更新（注意：通常は推奨されない方法）
    if ($lastId != 2) {
        // IDが2のレコードを探す
        $sql = "SELECT COUNT(*) FROM tbtest WHERE id = 2";
        $stmt = $pdo->query($sql);
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            // IDが2のレコードが存在しない場合にのみ更新
            $sql = "UPDATE tbtest SET id = 2 WHERE id = :lastId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':lastId', $lastId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
        }
    }

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
    
}
?>
