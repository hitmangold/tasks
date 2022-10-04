<?php
/* Task5:
$color = [4 => 'white', 6 => 'green', 11=> 'red'];
Write a PHP script to get the first element of the above array.
Expected result : white
 */
$color = [4 => 'white', 6 => 'green', 11=> 'red'];
$firstKey = array_key_first($color);
echo $firstKey;
?>