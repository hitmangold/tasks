<?php
/* Write a PHP script to extract the file name from the following string.
Sample String : 'www.example.com/public_html/index.blade.php'
Expected Output : 'index.blade.php'
 */
$str = 'www.example.com/public_html/index.blade.php';
$word = explode('/', $str);
echo $word[2];