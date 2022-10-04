<?php
/* Write a PHP script to find the first character that is different between two strings.
String1 : 'football'
String2 : 'footboll'
Expected Result : First difference between two strings at position 5: "a" vs "o" */
$str1 = 'football';
$str2 = 'footboll';
$str1 = str_split($str1);
$str2 = str_split($str2);
for($i=0; $i<count($str1); $i++){
    if($str1[$i] != $str2[$i]){
        echo 'First difference between two strings at position '.$i.': "'.$str1[$i].'" vs "'.$str2[$i].'"';
        break;
    }
}