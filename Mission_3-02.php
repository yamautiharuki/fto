<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>コメント一覧 - CSV表示</title>
    <link rel="stylesheet" href="styles.css"> <!-- CSSファイルのリンク -->
</head>
<body>
    <header>
        <h1>コメント一覧</h1>
        <nav>
            <ul>
                <li><a href="index.php">ホーム</a></li>
                <li><a href="display_comments.php">CSVコメント一覧</a></li>
                <li><a href="about.php">このサイトについて</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>CSVファイルからのコメント一覧</h2>
            <?php
            // CSVファイルのパス
            $csvFile = 'comments.csv';
            
            // ファイルが存在するかチェック
            if (file_exists($csvFile)) {
                // ファイルを開く
                if (($handle = fopen($csvFile, 'r')) !== false) {
                    echo "<table>";
                    echo "<tr><th>投稿番号</th><th>名前</th><th>コメント</th><th>投稿日時</th></tr>";
                    
                    // ファイルの内容を1行ずつ読み込む
                    while (($data = fgetcsv($handle)) !== false) {
                        // 各フィールドを変数に格納
                        list($id, $name, $comment, $timestamp) = $data;
                        
                        // HTMLとして表示
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td><strong>" . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "</strong></td>";
                        echo "<td>" . nl2br(htmlspecialchars($comment, ENT_QUOTES, 'UTF-8')) . "</td>";
                        echo "<td>" . htmlspecialchars($timestamp, ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "</tr>";
                    }
                    
                    echo "</table>";
                    // ファイルを閉じる
                    fclose($handle);
                } else {
                    echo "ファイルを開くことができませんでした。";
                }
            } else {
                echo "ファイルが存在しません。";
            }
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 簡易掲示板</p>
    </footer>
</body>
</html>
