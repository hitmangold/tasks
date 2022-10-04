<?php
/* Task7
Write a PHP script that inserts a new item in an array in any position.
Expected Output :
Original array :
1 2 3 4 5
After inserting '$' the array is :
1 2 3 $ 4 5
 */
$arr = [1,2,3,4,5];
prnt_arr($arr);
$inserted = array( '$' );
array_splice( $arr, 3, 0, $inserted );
prnt_arr($arr);
function prnt_arr($arg){
    foreach($arg as $value){
        echo $value . " ";
    }
    echo "<br>";
}