<?php
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