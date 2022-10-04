<?php

/* Write a PHP script to extract the user name from the following email ID.
Sample String : 'rayy@example.com'
Expected Output : 'rayy'

Write a PHP script to get the last three characters of a string.
Sample String : 'rayy@example.com'
Expected Output : 'com'

 */
$str = 'rayy@example.com';
$word = explode('@', $str);
echo $word[0] . '<br>';
$word = explode('.', $str); // @todo verjin 3 simvolna petq, petqa grvi henc verjin 3 hat@ cankacac stringi depqum
echo $word[1] . '<br>';
?>