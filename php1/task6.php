<?php
/* Task6:
Write a PHP script which decodes the following JSON string.
Sample JSON code :
{"Title": "The Cuckoos Calling",
"Author": "Robert Galbraith",
"Detail": {
"Publisher": "Little Brown"
}}
Expected Output :
Title : The Cuckoos Calling
Author : Robert Galbraith
Publisher : Little Brown
 */
$json = '{ "Title":"The Cuckoos Calling","Author":"Robert Galbraith","Detail":{ "Publisher":"Little Brown" } }';
$text_arr = json_decode($json, true);

foreach($text_arr as $key => $value){
    if(is_array($value)){
        foreach($value as $key2=>$value2){
            echo $key2 . " : " . $value2 . "<br>";
        }
    }
    else{
        echo $key . " : " . $value . "<br>";
    }
}