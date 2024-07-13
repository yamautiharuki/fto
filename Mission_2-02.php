<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>コメント受付フォーム</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="comment" placeholder="コメント" value="">
        <input type="submit" name="submit" value="送信">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comment"])) {
        $comment = trim($_POST["comment"]);
        
        if ($comment !== "") {
            // HTML特殊文字をエスケープ
            $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
            
            // テキストファイルに書き込む
            file_put_contents("comments.txt", $comment . PHP_EOL, FILE_APPEND | LOCK_EX);
            
            // コメントが「完成」の場合のギミック
            if ($comment === "完成") {
                echo "おめでとう！<br>";
            } else {
                echo "$comment を受け付けました。<br>";
            }
        }
    }
    ?>
</body>
</html>
