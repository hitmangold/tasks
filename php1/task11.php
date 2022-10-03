<?php
$array1 = [[77, 87], [23, 45]];
$array2 = ["w3resource", "com"];
array_unshift($array1[0], $array2[0]);
array_unshift($array1[1], $array2[1]);
print_r($array1);
?>