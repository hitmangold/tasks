<?php

class View
{
    function generate($content_view, $template_view, $data = null)
    {
        require_once('views/' . $template_view);
    }
}