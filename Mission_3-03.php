<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板フォーム</title>
</head>
<body>
    <h2>掲示板フォーム</h2>
    
    <form action="" method="post">
        <label for="name">名前：</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        
        <label for="comment">コメント：</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea>
        <br><br>
        
        <input type="submit" name="submit" value="送信">
    </form>
    
    <?php
    $csvFile = 'posts.csv';

    $postNumber = 1;

    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        $postNumber = count(file($csvFile)) + 1; 
        fclose($handle);
    }

    // POST送信の処理
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        $postDate = date("Y/m/d H:i:s");


        if (!empty($name) && !empty($comment)) {
            
            $data = [$postNumber, $name, $comment, $postDate];

                        if (($handle = fopen($csvFile, 'a')) !== FALSE) {
            
                fputcsv($handle, $data);
                fclose($handle);
                
                echo "<p>投稿が成功しました。</p>";
            } else {
                echo "<p>ファイル {$csvFile} を開けませんでした。</p>";
            }
        } else {
            echo "<p>名前とコメントは必須です。</p>";
        }
    }
    ?>
</body>
</html>
