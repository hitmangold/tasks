<?php
/* Task8:
Write a PHP script to sort the following associative array :
["Sophia"=>"31","Jacob"=>"41","William"=>"39","Ramesh"=>"40"] in
a) ascending order sort by value
b) ascending order sort by Key
c) descending order sorting by Value
d) descending order sorting by Key
 */
$newarr = ["Sophia"=>"31","Jacob"=>"41","William"=>"39","Ramesh"=>"40"];
$temp = array();
foreach ($newarr as $key => $row)
{
    $temp[$key] = $row;
}
array_multisort($newarr,SORT_ASC, $temp, SORT_ASC);
print_r($newarr);
echo '<br>';
ksort($newarr);
print_r($newarr);
echo '<br>';
array_multisort($newarr,SORT_DESC, $temp, SORT_DESC);
print_r($newarr);
echo '<br>';
krsort($newarr);
print_r($newarr);
?>