<?php
// 掛け
$val1 = 6;
$val2 = 2;
$num1 = 10;
$num2 = 2;
$result_ = $num1 * $num2;
echo "$result_\n";

// 割り算
if ($num2 != 0) {
    $result_ = $num1 / $num2;
    echo "$result_\n";
} 
?>
<?php
// 足し算
$num1 = 10;
$num2 = 2;
$result_add = $num1 + $num2;
echo "$result_add\n";

// 引き算
$result_subtract = $num1 - $num2;
echo "$result_subtract\n";
?>
<?php

// 割り算の余り
if ($num2 != 0) {
    $remainder = $num1 % $num2;
    echo "$remainder\n";
} else {
    echo "エラー\n";
}
?>
