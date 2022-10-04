<?php
/* Write a PHP script to extract the file name from the following string.
Sample String : 'www.example.com/public_html/index.php'
Expected Output : 'index.php'
 */
$str = 'www.example.com/public_html/index.php';
$word = explode('/', $str);
echo $word[2];