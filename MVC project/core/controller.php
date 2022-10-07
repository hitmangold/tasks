<?php
class Controller {

    public $model;
    public $view;

    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
    }
}