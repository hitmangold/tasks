<?php
/* Task9:
Write a PHP script to calculate and display average temperature, five lowest and highest temperatures.
Recorded temperatures : 78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73
Expected Output :
Average Temperature is : 70.6
List of five lowest temperatures : 60, 62, 63, 63, 64,
List of five highest temperatures : 76, 78, 79, 81, 85,
 */
$temperatures = [78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73];
function get_value($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        echo $arr[$i] . " ";
    }
}
get_value($temperatures);
echo '<br>';
rsort($temperatures);
$a = array_filter($temperatures);
$average = floor(array_sum($a)/count($a) * 100)/100;
echo 'Average Temperature is : ' . $average;
$firstFiveElements = array_slice($temperatures, count($temperatures)-5, 5);
sort($firstFiveElements);
$lastFiveElements = array_slice($temperatures, 0, 5);
$fivelowest = '';
$fivehighest = '';
$fivelowest = implode(" ",$firstFiveElements);
$fivehighest = implode(" ",$lastFiveElements);
echo '<br>';
echo 'List of five lowest temperatures : ' . $fivelowest;
echo '<br>';
echo 'List of five highest temperatures : ' . $fivehighest;