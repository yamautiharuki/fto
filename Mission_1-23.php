<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>入力した値でFizzBuzz</title>
</head>
<body>
    <form action="" method="post">
        <input type="number" name="num" placeholder="数字を入力してください">
        <input type="submit" name="submit" value="送信">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["num"])) {
        $num = $_POST["num"];
        
        if (is_numeric($num)) {
            $num = (int)$num;
            
            if ($num % 3 == 0 && $num % 5 == 0) {
                echo "FizzBuzz<br>";
            } elseif ($num % 3 == 0) {
                echo "Fizz<br>";
            } elseif ($num % 5 == 0) {
                echo "Buzz<br>";
            } else {
                echo $num . "<br>";
            }
        } else {
            echo "有効な数字を入力してください。<br>";
        }
    }
    ?>
</body>
</html>
