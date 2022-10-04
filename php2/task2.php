<?php
/* Task: Ստեղծել 2 զանգված: 1-ին զանգվածի տարրերը այբուբենի փոքրատառ և մեծատառ
[a-z] և [A-Z] տառերն են, երկրորդ զանգվածը 0-9 թվերը: Ստեղծել form
Գեներացնել սեղմելուց հետո ստեղծել  նշված քանակի սիմվոլներով և նշված պարամետրերով տող ,
օգտագործելով եղած երկու զանգվածները և տպել էկրանին:
*/
function generate_pass($length,$type){
    $alphabet = [['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'],['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']];
    $num = [0,1,2,3,4,5,6,7,8,9];
    $errors = array(
        'error' => False,
        'message' => ''
    );
    if($length == null or $length == '' or $length == 0 or strlen($length) == 0){
        if($errors['error'] == False) {
            $errors['error'] = True;
            $errors['message'] = 'Տողի երկարությունը չի կարող դատարկ լինել կամ 0';
        }
    }
    if($length < 6 or $length > 42){
        if($errors['error'] == False) {
            $errors['error'] = True;
            $errors['message'] = 'Տողի երկարությունը չի կարող լինել 6ից փոքր կամ մեծ 42 ից';
        }
    }
    if(!is_numeric($length)){
        if($errors['error'] == False) {
            $errors['error'] = True;
            $errors['message'] = 'Տողի երկարությունը նշել թվով';
        }
    }
    if($errors['error'] != True){
        $generated_pass = '';
        if($type == 1){
            for($i=0;$i<$length;$i++){
                $rand = rand(0,9);
                $generated_pass .= $num[$rand];
            }
        }
        else if($type == 2){
            for($i=0;$i<$length;$i++){
                $rand = rand(0,1);
                if($rand == 0){
                    $rand = rand(0,25);
                    $generated_pass .= $alphabet[0][$rand];
                }
                else{
                    $rand = rand(0,25);
                    $generated_pass .= $alphabet[1][$rand];
                }
            }
        }
        else{
            for($i=0; $i<$length; $i++){
                $rand = rand(0,1);
                if($rand == 0){
                    $rand = rand(0,9);
                    $generated_pass .= $num[$rand];
                }
                else{
                    $rand = rand(0,1);
                    if($rand == 0){
                        $rand = rand(0,25);
                        $generated_pass .= $alphabet[0][$rand];
                    }
                    else{
                        $rand = rand(0,25);
                        $generated_pass .= $alphabet[1][$rand];
                    }
                }
            }
        }
        return $generated_pass;
    }
    else{
        return $errors['message'];
    }
}
$type = 0;
$length = 0;
if(isset($_GET['submit']) and isset($_GET['length']) and isset($_GET['type'])){
    $type = $_GET['type'];
    $length = $_GET['length'];
    $result = generate_pass($length,$type);
    echo $result;
}
echo '<form action="task2.php" method="get">';
if($length == 0) {
    echo '<input placeholder="Տողի երկարությունը" name="length" type="text" width="150px">';
}
else{
    echo '<input placeholder="Տողի երկարությունը" value="'.$length.'" name="length" type="text" width="150px">';
}
echo '<p>Տողմի մեջ ներառել</p>';
if($type == 0) {
    echo '<select name="type" style="width: 170px;"><option value="1">Թվեր</option><option value="2">Տառեր</option><option value="3">Թվեր և Տառեր</option></select><br>';
}
else if($type == 1){
    echo '<select name="type" style="width: 170px;"><option value="1" selected="1">Թվեր</option><option value="2">Տառեր</option><option value="3">Թվեր և Տառեր</option></select><br>';
}
else if($type == 2){
    echo '<select name="type" style="width: 170px;"><option value="1">Թվեր</option><option value="2" selected="2">Տառեր</option><option value="3">Թվեր և Տառեր</option></select><br>';
}
else if($type == 3){
    echo '<select name="type" style="width: 170px;"><option value="1">Թվեր</option><option value="2">Տառեր</option><option value="3" selected="3">Թվեր և Տառեր</option></select><br>';
}
echo '<input value="Գեներացնել" type="submit" name="submit" style="margin-top: 20px;">';
echo '</form>';
if(isset($_GET['submit'])) {
    echo '<p class="generate_txt" style="font-size: 17px; font-weight: 500; font-weight: bold;"><?=$result?></p>';
}