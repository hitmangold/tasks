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
loop($arr);
$inserted = array( '$' );
array_splice( $arr, 3, 0, $inserted );
loop($arr);
function loop($arg){ // @todo cikler@ himnakanum ogtagorcum enq foreach, functioni anunnel kara lini
    // printArray kam inchvor urish ban, loop@ shat globala
    for($i=0; $i<count($arg); $i++){
        echo $arg[$i] . " ";
    }
    echo "<br>";
}
?>