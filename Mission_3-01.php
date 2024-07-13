
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>簡易掲示板</title>
</head>
<body>
    <h1>簡易掲示板</h1>

    <form action="" method="post">
        <label for="comment">コメント：</label>
        <input type="text" id="comment" name="comment" required>
        <input type="submit" name="submit" value="投稿">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comment"])) {
        $comment = trim($_POST["comment"]);

        if ($comment !== "") {
            // CSVファイルに書き込むデータを準備する
            $data = [date("Y/m/d H:i:s"), $comment];

            // CSVファイルにデータを追記する
            $file = fopen("comments.csv", "a");
            fputcsv($file, $data);
            fclose($file);

            echo "コメントを受け付けました。<br>";
        }
    }

    // CSVファイルからデータを読み込んで表示する
    if (($handle = fopen("comments.csv", "r")) !== FALSE) {
        echo "<h2>投稿履歴</h2>";
        echo "<ul>";
        while (($data = fgetcsv($handle)) !== FALSE) {
            echo "<li>" . htmlspecialchars($data[0], ENT_QUOTES, 'UTF-8') . " : " . htmlspecialchars($data[1], ENT_QUOTES, 'UTF-8') . "</li>";
        }
        echo "</ul>";
        fclose($handle);
    } else {
        echo "まだ投稿はありません。";
    }
    ?>
</body>
</html>
