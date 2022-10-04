<?php
/* Task: Ձեր պատկերացմամբ ստեղծեք ավտոմեքնաների աբստրակտ կլաս:
Ստեղծեք տարբեր մակնիշի ավտոմեքենաների կլասներ, որոնք կժառանգվեն ավտոմեքնաների աբստրակտ կլասից և կվերաորոշեն նրա
աբստրակտ մեթոդները ըստ կոնկրետ մակնիշի:
Ստեղծեք ավտոմեքենաների մակնիշների օբյեկտները,
որոնք կոնստրուկտորի միջոցով կստանան կոնկրետ մոդելի պարամետրերը և կփոխանցեն կլասի հատկանիշներին
( մեքենայի գույն, արագություն, փոխանցման տուփ, տարեթիվ…) : Կանչել օբյեկտի մեթոդները և արդյունքները տպել էկրանին:
 */
abstract class Vehicles{
    protected $color;
    protected $speed;
    protected $transmission;
    protected $year;

    public function __construct($color,$speed,$transmission,$year)
    {
        $this->color = $color;
        $this->speed = $speed;
        $this->transmission = $transmission;
        $this->year = $year;
    }
    abstract function fullinfo();
    abstract function partinfo();
}
class Mercedes extends Vehicles{
    protected $model;
    public function __construct($color,$speed,$transmission,$year,$model){
        parent::__construct($color, $speed,$transmission,$year);
        $this->model = $model;
    }
    public function fullinfo(){
        return 'Model: Mercedes '. $this->model .', Color: ' . $this->color . ', Speed: ' . $this->speed . ', Transmission: ' . $this->transmission . ', Year: ' . $this->year;
    }
    public function partinfo(){
        return 'Model: Mercedes '. $this->model .', Color: ' . $this->color . ', Year: ' . $this->year;
    }
}
class Bmw extends Vehicles{
    protected $model;
    public function __construct($color,$speed,$transmission,$year,$model){
        parent::__construct($color, $speed,$transmission,$year);
        $this->model = $model;
    }
    public function fullinfo(){
        return 'Model: BMW '. $this->model .', Color: ' . $this->color . ', Speed: ' . $this->speed . ', Transmission: ' . $this->transmission . ', Year: ' . $this->year;
    }
    public function partinfo(){
        return 'Model: BMW '. $this->model .', Color: ' . $this->color . ', Year: ' . $this->year;
    }
}
class Toyota extends Vehicles{
    protected $model;
    public function __construct($color,$speed,$transmission,$year,$model){
        parent::__construct($color, $speed,$transmission,$year);
        $this->model = $model;
    }
    public function fullinfo(){
        return 'Model: Toyota '. $this->model .', Color: ' . $this->color . ', Speed: ' . $this->speed . ', Transmission: ' . $this->transmission . ', Year: ' . $this->year;
    }
    public function partinfo(){
        return 'Model: Toyota '. $this->model .', Color: ' . $this->color . ', Year: ' . $this->year;
    }
}
$mycar = new Mercedes('Black', '320km','Automatic','2008','W220');
$mycar2 = new Bmw('White', '340km','Automatic','2010','M5');
$mycar3 = new Toyota('Gray', '280km','Automatic','2012','Camry');
echo $mycar->fullinfo() . '<br>';
echo $mycar2->partinfo() . '<br>';
echo $mycar3->fullinfo() . '<br>';
?>