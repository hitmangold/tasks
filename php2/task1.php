<?php
/* Task 1 Ստեղծել կամայական չափի զանգված, որի  տարրերը random ձևով գեներացված
1-100 միջակայքում ընկած ամբողջ տիպի թվեր են.  Տպել էկրանին զանգվածը:
Զանգվածից հեռացնել կրկնվող տարրերը: Դասավորել ըստ նվազման և տպել էկրանին 2 սյունակից կազմված աղյուսակի տեսքով
 ( հերթական համար , զանգվածի տարր). */
$arr = [];
function randint_arr($arr,$count){
    for($i=0; $i<$count; $i++){
        $rand = rand(1,100);
        array_push($arr, $rand);
    }
    return $arr;
}
$arr = randint_arr($arr,50);
print_r($arr);
rsort($arr);
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