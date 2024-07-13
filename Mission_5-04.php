<?php
$dsn = 'mysql:dbname=tb260040db;host=localhost';
$user = 'tb-260040';
$password = 'GbcXUsGse5';

// パスワード定義
$correct_password = 'tomo';

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
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);

    // 既存のテーブルに password カラムが存在するかチェックし、存在しない場合は追加
    $sql = "SHOW COLUMNS FROM comments LIKE 'password'";
    $result = $pdo->query($sql)->fetch();

    if (!$result) {
        $sql = "ALTER TABLE comments ADD COLUMN password VARCHAR(255) NOT NULL DEFAULT 'tomo'";
        $pdo->exec($sql);
    }

    // 投稿処理
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submit"]) && $_POST["submit"] == "投稿") {
            $name = trim($_POST["name"]);
            $comment = trim($_POST["comment"]);
            $password = trim($_POST["password"]);

            if ($name !== "" && $comment !== "" && $password === $correct_password) {
                // データベースにコメントを挿入するSQL
                $sql = "INSERT INTO comments (name, comment, password) VALUES (:name, :comment, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();

                echo "コメントを受け付けました。<br>";
            } else {
                echo "名前、コメントを正しく入力し、正しいパスワードを入力してください。<br>";
            }
        } elseif (isset($_POST["submit"]) && $_POST["submit"] == "削除") {
            $delete_id = intval($_POST["delete_id"]);
            $password = trim($_POST["password"]);

            if ($delete_id > 0 && $password === $correct_password) {
                // パスワードが一致するコメントを削除するSQL
                $sql = "DELETE FROM comments WHERE id = :id AND password = :password";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo "コメントを削除しました。<br>";
                } else {
                    echo "パスワードが一致しません。<br>";
                }
            } else {
                echo "削除対象番号と正しいパスワードを入力してください。<br>";
            }
        } elseif (isset($_POST["submit"]) && $_POST["submit"] == "編集") {
            $edit_id = intval($_POST["edit_id"]);
            $password = trim($_POST["password"]);

            // 編集対象のコメントを取得するSQL
            $sql = "SELECT name, comment FROM comments WHERE id = :id AND password = :password";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($edit_data) {
                // 編集フォームで表示する初期値を設定
                $edit_name = $edit_data['name'];
                $edit_comment = $edit_data['comment'];
            } else {
                echo "指定された編集対象番号のコメントは見つかりませんでした。<br>";
            }
        } elseif (isset($_POST["update"])) {
            $edit_id = intval($_POST["edit_id"]);
            $edited_name = trim($_POST["edit_name"]);
            $edited_comment = trim($_POST["edit_comment"]);
            $password = trim($_POST["password"]);

            if ($edit_id > 0 && $edited_name !== "" && $edited_comment !== "" && $password === $correct_password) {
                // データベース内のコメントを更新するSQL
                $sql = "UPDATE comments SET name = :name, comment = :comment WHERE id = :id AND password = :password";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $edited_name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $edited_comment, PDO::PARAM_STR);
                $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo "コメントを編集しました。<br>";
                } else {
                    echo "パスワードが一致しません。<br>";
                }

                // 編集後、初期値をリセットする
                $edit_id = null;
                $edit_name = "";
                $edit_comment = "";
            } else {
                echo "名前、コメントを正しく入力し、正しいパスワードを入力してください。<br>";
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
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($edit_name, ENT_QUOTES, 'UTF-8'); ?>" required>
        <br>
        <label for="comment">コメント：</label>
        <input type="text" id="comment" name="comment" value="<?php echo htmlspecialchars($edit_comment, ENT_QUOTES, 'UTF-8'); ?>" required>
        <br>
        <label for="password">パスワード：</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" name="submit" value="投稿">
    </form>

    <form action="" method="post">
        <label for="delete_id">削除対象番号：</label>
        <input type="number" id="delete_id" name="delete_id" required>
        <br>
        <label for="password">パスワード：</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" name="submit" value="削除">
    </form>

    <!-- 編集番号指定用フォーム -->
    <h2>コメント編集</h2>
    <form action="" method="post">
        <label for="edit_id">編集対象番号：</label>
        <input type="number" id="edit_id" name="edit_id" required>
        <br>
        <label for="password">パスワード：</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" name="submit" value="編集">
    </form>

    <!-- 編集フォーム -->
    <?php if ($edit_id !== null): ?>
        <h3>編集フォーム</h3>
        <form action="" method="post">
            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($edit_id, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="edit_name">名前：</label>
            <input type="text" id="edit_name" name="edit_name" value="<?php echo htmlspecialchars($edit_name, ENT_QUOTES, 'UTF-8'); ?>" required>
            <br>
            <label for="edit_comment">コメント：</label>
            <input type="text" id="edit_comment" name="edit_comment" value="<?php echo htmlspecialchars($edit_comment, ENT_QUOTES, 'UTF-8'); ?>" required>
            <br>
            <label for="password">パスワード：</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" name="update" value="更新">
        </form>
    <?php endif; ?>

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





