<?php
$arr = [];
function randint_arr($arr,$count){
    for($i=0; $i<$count; $i++){
        $rand = rand(1,100);
        array_push($arr, $rand);
    }
    return $arr;
}
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
$arr = randint_arr($arr,50);
print_r($arr);
$arr = bubble_Sort($arr,'DESC');
$arr = array_unique($arr);
$arr = array_values($arr);
echo '<table style="width: 250px; border: 1px solid black; margin-top: 30px;">';
$new_count = 1;
for($i=0;$i<count($arr); $i++){
    echo '<tr align="center">';
    echo '<td style="border: 1px solid #dddddd;">'.$new_count.'</td>';
    echo '<td style="border: 1px solid #dddddd;">'.$arr[$i].'</td>';
    echo '</tr>';
    $new_count++;
}
echo '</table>';
?>