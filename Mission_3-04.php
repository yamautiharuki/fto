<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板フォーム</title>
    <style>
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
        .name {
            font-weight: bold;
            color: blue;
        }
        .comment {
            color: green;
        }
    </style>
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

    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
        $comment = htmlspecialchars($_POST["comment"], ENT_QUOTES, 'UTF-8');
        $postDate = date("Y/m/d H:i:s");

        
        if (!empty($name) && !empty($comment)) {
            
            $newRow = [$name, $comment, $postDate];

            
            if (($handle = fopen($csvFile, 'a')) !== FALSE) {
                fputcsv($handle, $newRow);
                fclose($handle);
                
                echo "<p>投稿が成功しました。</p>";
            } else {
                echo "<p>ファイル {$csvFile} を開けませんでした。</p>";
            }
        } else {
            echo "<p>名前とコメントは必須です。</p>";
        }
    }

    echo "<h2>投稿履歴</h2>";
    echo "<ul>";

    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        $postNumber = 1; 

        while (($data = fgetcsv($handle)) !== FALSE) {
            if (count($data) === 3) {
                echo "<li>";
                echo "<span style='font-size: 80%; color: #999;'>投稿番号：{$postNumber}</span><br>";
                echo "<span class='name'>" . htmlspecialchars($data[0], ENT_QUOTES, 'UTF-8') . "</span> : ";
                echo "<span class='comment'>" . htmlspecialchars($data[1], ENT_QUOTES, 'UTF-8') . "</span><br>";
                echo "<span style='font-size: 80%; color: #999;'>投稿日時：" . htmlspecialchars($data[2], ENT_QUOTES, 'UTF-8') . "</span>";
                echo "</li>";
                $postNumber++;
            }
        }
        fclose($handle);
    } else {
        echo "<p>投稿はありません。</p>";
    }

    echo "</ul>";
    ?>
</body>
</html>


