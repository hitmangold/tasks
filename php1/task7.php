<?php
$arr = [1,2,3,4,5];
loop($arr);
$inserted = array( '$' );
array_splice( $arr, 3, 0, $inserted );
loop($arr);
function loop($arg){
    for($i=0; $i<count($arg); $i++){
        echo $arg[$i] . " ";
    }
    echo "<br>";
}
?>