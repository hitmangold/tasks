<?php
$str = 'the quick brown fox jumps over the lazy dog';
$new_str = explode(" ", $str);
function replace($str)
{
    $result = '';
    $count = 0;
    for ($i = 0; $i < count($str); $i++) {
        if($str[$i] == 'the' and $count == 0){
            $str[$i] = 'That';
            $count++;
        }
        $result .= $str[$i] . " ";
    }
    return $result;
}
$str = replace($new_str);
print_r($str);
?>