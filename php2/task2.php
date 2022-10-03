<?php
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
if(isset($_GET['submit']) and isset($_GET['length']) and isset($_GET['type'])){
    $result = generate_pass($_GET['length'],$_GET['type']);
    echo $result;
}
echo '<form action="task2.php" method="get">';
echo '<input placeholder="Տողի երկարությունը" name="length" type="text" width="150px">';
echo '<p>Տողմի մեջ ներառել</p>';
echo '<select name="type" style="width: 170px;"><option value="1">Թվեր</option><option value="2">Տառեր</option><option value="3">Թվեր և Տառեր</option></select><br>';
echo '<input value="Գեներացնել" type="submit" name="submit" style="margin-top: 20px;">';
echo '</form>';
if(isset($_GET['submit'])) {
    echo '<p class="generate_txt" style="font-size: 17px; font-weight: 500; font-weight: bold;"><?=$result?></p>';
}
?>