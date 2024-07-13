<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>入力フォームを試す</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="str">
        <input type="submit" name="submit" value="送信">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $str = $_POST["str"];
        echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
    ?>
</body>
</html>
