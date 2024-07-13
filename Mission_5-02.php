<?php
$dsn = 'mysql:dbname=データベース;host=localhost';
$user = 'ユーザー名';
$password = 'データベース';
// 編集フォームで表示する初期値
$edit_id = null;
$edit_name = "";
$edit_comment = "";

try {
    // PDOインスタンスを生成
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // コメントテーブルが存在しない場合は作成
    $sql = "CREATE TABLE IF NOT EXISTS comments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);

    // 投稿処理
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submit"]) && $_POST["submit"] == "投稿") {
            $name = trim($_POST["name"]);
            $comment = trim($_POST["comment"]);

            if ($name !== "" && $comment !== "") {
                // データベースにコメントを挿入するSQL
                $sql = "INSERT INTO comments (name, comment) VALUES (:name, :comment)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->execute();

                echo "コメントを受け付けました。<br>";
            }
        } elseif (isset($_POST["submit"]) && $_POST["submit"] == "削除") {
            $delete_id = intval($_POST["delete_id"]);

            if ($delete_id > 0) {
                // データベースからコメントを削除するSQL
                $sql = "DELETE FROM comments WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
                $stmt->execute();

                echo "コメントを削除しました。<br>";
            }
        }
    }

    // 投稿履歴の表示
    $sql = "SELECT * FROM comments ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    $comments = $stmt->fetchAll();
} catch (PDOException $e) {
    // エラーメッセージを表示
    echo "データベース接続またはデータ操作に失敗しました: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>簡易掲示板</title>
</head>
<body>
    <h1>簡易掲示板</h1>

    <form action="" method="post">
        <label for="name">名前：</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="comment">コメント：</label>
        <input type="text" id="comment" name="comment" required>
        <input type="submit" name="submit" value="投稿">
    </form>

    <form action="" method="post">
        <label for="delete_id">削除対象番号：</label>
        <input type="number" id="delete_id" name="delete_id" required>
        <input type="submit" name="submit" value="削除">
    </form>

    <?php if (!empty($comments)): ?>
        <h2>投稿履歴</h2>
        <ul>
            <?php foreach ($comments as $comment): ?>
                <li>
                    <?php echo htmlspecialchars($comment['id'], ENT_QUOTES, 'UTF-8'); ?>:
                    <?php echo htmlspecialchars($comment['created_at'], ENT_QUOTES, 'UTF-8'); ?> : 
                    <?php echo htmlspecialchars($comment['name'], ENT_QUOTES, 'UTF-8'); ?> : 
                    <?php echo htmlspecialchars($comment['comment'], ENT_QUOTES, 'UTF-8'); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>まだ投稿はありません。</p>
    <?php endif; ?>
</body>
</html>
