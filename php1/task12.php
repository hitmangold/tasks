<?php
/* Task12:
   Write a PHP function to change the following array's all values to upper or lower case.
Sample arrays :
$Color = ['A' => 'Blue', 'B' => 'Green', 'c' => 'Red'];
Expected Output :
Values are in lower case.
Array ( [A] => blue [B] => green [c] => red )
Values are in upper case.
Array ( [A] => BLUE [B] => GREEN [c] => RED )
 */
$Color = ['A' => 'Blue', 'B' => 'Green', 'c' => 'Red'];
foreach($Color as $key=>$value){
    $lowercase = strtolower($value);
    $Color[$key] = $lowercase;
}
print_r("Values are in lower case.");
echo '<br>';
print_r($Color);
echo '<br>';
print_r("Values are in upper case.");
echo '<br>';
foreach($Color as $key=>$value){
    $uppercase = strtoupper($value);
    $Color[$key] = $uppercase;
}
print_r($Color);
?>