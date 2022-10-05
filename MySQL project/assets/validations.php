<?php
class Valid{
    public $errors = array(
        'error' => False,
        'message' => ''
    );
    public function product_validation($name,$description,$price){
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        if(strlen($this->name) == 0){
            if($this->errors['error'] == False){
                $this->errors['error'] = True;
                $this->errors['message'] = 'Խնդրում ենք մուտքագրել անվանումը';
            }
        }
        if(strlen($this->price) == 0){
            if($this->errors['error'] == False){
                $this->errors['error'] = True;
                $this->errors['message'] = 'Խնդրում ենք մուտքագրել գինը';
            }
        }
        if(!is_numeric($this->price)){
            if($this->errors['error'] == False){
                $this->errors['error'] = True;
                $this->errors['message'] = 'Խնդրում ենք մուտքագրել ճիշտ գին';
            }
        }
        if(strlen($this->description) == 0){
            if($this->errors['error'] == False){
                $this->errors['error'] = True;
                $this->errors['message'] = 'Խնդրում ենք մուտքագրել նկարագրությունը';
            }
        }
        if($this->errors['error'] == False){
            return null;
        }
        else{
            return $this->errors['message'];
        }
    }
    public function user_validation($name,$surname,$email){
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        if(strlen($this->name) == 0){
            if($this->errors['error'] == False){
                $this->errors['error'] = True;
                $this->errors['message'] = 'Խնդրում ենք նշել ձեր անունը';
            }
        }
        if(strlen($this->surname) == 0){
            if($this->errors['error'] == False){
                $this->errors['error'] = True;
                $this->errors['message'] = 'Խնդրում ենք նշել ձեր ազգանունը';
            }
        }
        if(strlen($this->email) == 0){
            if($this->errors['error'] == False){
                $this->errors['error'] = True;
                $this->errors['message'] = 'Խնդրում ենք նշել ձեր էլ.հասցեն';
            }
        }
        if(!preg_match('/^[a-z]+@[a-z]+[.][a-z]+/', $this->email)){
            if($this->errors['error'] == False){
                $this->errors['error'] = True;
                $this->errors['message'] = 'էլ.հասցեն սխալ է մուտքագրված';
            }
        }
        if($this->errors['error'] == False){
            return null;
        }
        else{
            return $this->errors['message'];
        }
    }
}