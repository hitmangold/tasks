<?php

class Controller_Main extends Controller
{
    function view()
    {
        $data = $this->model->get_data();
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }
}