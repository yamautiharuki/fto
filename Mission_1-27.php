<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>FizzBuzz記録と表示</title>
</head>
<body>
    <h2>FizzBuzz記録と表示</h2>

    <form action="" method="post">
        <label for="number">数値を入力してください：</label>
        <input type="number" id="number" name="number" required>
        <input type="submit" name="submit" value="送信">
    </form>

    <?php
    // ファイル名
    $fileName = 'kkk.txt';

    // POST送信された場合の処理
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        // 入力された数値を取得
        $number = $_POST["number"];

        // ファイルに数値を追記する
        if (($handle = fopen($fileName, 'a')) !== FALSE) {
            fwrite($handle, $number . PHP_EOL); // 数字をそのまま書き込む（改行あり）
            fclose($handle);
            echo "書き込み成功！<br>";
        } else {
            echo "ファイル {$fileName} を開けませんでした。<br>";
        }
    }

    // ファイルの内容を読み込んで表示する
    if (file_exists($fileName)) {
        $lines = file($fileName, FILE_IGNORE_NEW_LINES); // 改行を除いてファイルを配列として読み込む

        if (!empty($lines)) {
            echo "表示：<br>";
            foreach ($lines as $line) {
                // FizzBuzzの条件に応じて表示を変換する
                $num = intval($line);
                $output = '';
                if ($num % 3 == 0) {
                    $output .= 'Fizz';
                }
                if ($num % 5 == 0) {
                    $output .= 'Buzz';
                }
                if (empty($output)) {
                    $output = $num; // FizzBuzz条件に当てはまらない場合はそのままの数値を表示
                }
                echo $output . ' ';
            }
        } else {
            echo "ファイルにはまだ何も書かれていません。";
        }
    } else {
        echo "ファイル {$fileName} が存在しません。";
    }
    ?>
</body>
</html>
