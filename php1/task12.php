<?php
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