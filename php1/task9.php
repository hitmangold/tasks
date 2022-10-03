<?php
$temperatures = [78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73];
function bubble_Sort($my_array,$order)
{
    do
    {
        $swapped = false;
        for( $i = 0, $c = count( $my_array ) - 1; $i < $c; $i++ )
        {
            if($order == 'DESC'){
                if( $my_array[$i] < $my_array[$i + 1] )
                {
                    list( $my_array[$i + 1], $my_array[$i] ) =
                        array( $my_array[$i], $my_array[$i + 1] );
                    $swapped = true;
                }
            }
            else if($order == 'ASC'){
                if( $my_array[$i] > $my_array[$i + 1] )
                {
                    list( $my_array[$i + 1], $my_array[$i] ) =
                        array( $my_array[$i], $my_array[$i + 1] );
                    $swapped = true;
                }
            }
        }
    }
    while( $swapped );
    return $my_array;
}
function get_value($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        echo $arr[$i] . " ";
    }
}
get_value($temperatures);
echo '<br>';
$sorted_temp = bubble_Sort($temperatures,'DESC');
$a = array_filter($sorted_temp);
$average = floor(array_sum($a)/count($a) * 100)/100;
echo 'Average Temperature is : ' . $average;
$firstFiveElements = array_slice($sorted_temp, count($sorted_temp)-5, 5);
$firstFiveElements = bubble_Sort($firstFiveElements,'ASC');
$lastFiveElements = array_slice($sorted_temp, 0, 5);
$fivelowest = '';
$fivehighest = '';
for($i=0; $i<count($firstFiveElements); $i++){
    $fivelowest .= $firstFiveElements[$i] . " ";
}
for($i=0; $i<count($lastFiveElements); $i++){
    $fivehighest .= $lastFiveElements[$i] . " ";
}
echo '<br>';
echo 'List of five lowest temperatures : ' . $fivelowest;
echo '<br>';
echo 'List of five highest temperatures : ' . $fivehighest;
?>