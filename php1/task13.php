<?php
$sample_str = 'The quick brown fox jumps over the lazy dog.';
echo 'a: ' . strtoupper($sample_str) . '<br>';
echo 'b: ' . strtolower($sample_str) . '<br>';
echo 'c: ' . $sample_str . '<br>';
$words = explode(' ', $sample_str);
$last_text = '';
for($i=0; $i<count($words); $i++){
    $words[$i] = strtoupper(substr($words[$i],0,1)) . substr($words[$i],1);
    $last_text .= $words[$i] . ' ';
}
echo 'd: ' . $last_text;
?>