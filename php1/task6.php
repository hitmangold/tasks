<?php
$json = '{ "Title":"The Cuckoos Calling","Author":"Robert Galbraith","Detail":{ "Publisher":"Little Brown" } }';
$myjson = json_decode($json, true);

foreach($myjson as $key => $value){
    if(is_array($value)){
        foreach($value as $key2=>$value2){
            echo $key2 . " : " . $value2 . "<br>";
        }
    }
    else{
        echo $key . " : " . $value . "<br>";
    }
}
?>