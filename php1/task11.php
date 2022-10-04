<?php
/* Task 10 chkar grvacer skip:
Task 11:
Write a PHP program to merge (by index) the following two arrays.
Sample arrays :
$array1 = [array[77, 87], [23, 45]];
$array2 = ["w3resource", "com"];
Expected Output :
Array
(
[0] => Array
(
[0] => w3resource
[1] => 77
[2] => 87
)
[1] => Array
(
[0] => com
[1] => 23
[2] => 45
)
)
 */
$array1 = [[77, 87], [23, 45]];
$array2 = ["w3resource", "com"];
array_unshift($array1[0], $array2[0]);
array_unshift($array1[1], $array2[1]);
print_r($array1);
?>