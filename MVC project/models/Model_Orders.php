<?php

class Model_Main
{
    public function get_data()
    {
        $instance = Database::getinstance();
        $conn = $instance->getconnection();
        $all_orders = new Query($conn, 'order');
        $get_orders_query = $all_orders->select();
        return $get_orders_query;
    }
}