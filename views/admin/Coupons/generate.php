<?php
            
$chars = '12345ABCDEFGHIJKLMNOPQRSTUVWXYZ67890';
$hashpromo = '';
for($ichars = 0; $ichars < 9; ++$ichars) {
    $random = str_shuffle($chars);
    $hashpromo .= $random[0];
}

echo $hashpromo;
            
?>