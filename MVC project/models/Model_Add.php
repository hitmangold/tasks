<?php

class Model_Main
{
    public function get_data()
    {
        $data = array(
            'errors' => false,
            'message' => ''
        );
        if (isset($_POST['add_product']) and isset($_POST['name_product']) and isset($_POST['price_product']) and isset($_POST['description_product'])) {
            require_once('configs/validations.php');
            $instance = Database::getinstance();
            $conn = $instance->getconnection();
            $name_product = $_POST['name_product'];
            $price_product = $_POST['price_product'];
            $description_product = $_POST['description_product'];
            $valid = new Valid();
            $valid = $valid->product_validation(
                $name_product,
                $description_product,
                $price_product
            );
            if ($valid == null) {
                $prd_rows = 'name,description,price';
                $insert_prd = "'{$name_product}','{$description_product}','{$price_product}'";
                $insert_query = new Query($conn, 'products', $prd_rows, $insert_prd);
                $insert_query->insert();
            } else {
                $data['errors'] = true;
                $data['message'] = $valid;
            }
        }
        return $data;
    }
}