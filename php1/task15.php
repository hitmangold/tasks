<?php
$str = 'rayy@example.com';
$word = explode('@', $str);
echo $word[0] . '<br>';
$word = explode('.', $str);
echo $word[1] . '<br>';
?>