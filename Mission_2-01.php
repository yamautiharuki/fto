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
        $comment = htmlspecialchars($_POST["comment"], ENT_QUOTES, 'UTF-8');
        echo "$comment を受け付けました。<br>";
    }
    ?>
</body>
</html>
