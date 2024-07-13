<?php
$items = array("Ken", "Alice", "Judy", "BOSS", "Bob");

foreach ($items as $item) {
    if ($item == "BOSS") {
        echo "Good morning $item!<br>";
    } else {
        echo "Hi! $item<br>";
    }
}
?>
 <?php
    // 配列を用意
    $items = array("Ken","Alice","Judy","BOSS","Bob"); 
 
    // カウンタ用の変数と、配列変数の要素カウントを用意
    $i = 0;
    $count = count($items); 

    // whileでループ。
    while ($i < $count) {
        $item = $items[$i];
        echo  $item ." イケメン.  <br>"; 

    
        $i++;
    }
?>