<?php
    // この数字を様々に変えてみよう：3、5、15、4、など
    $num = 15; 

    if($num%3==0 && $num%5==0){
        echo "FizzBuzz<br>";
    }elseif ($num%3==0){
        echo "Fizz<br>";
    }elseif($num%5==0){
        echo "Buzz<br>";
    }else{
        echo $num . "<br>";
    }
?>