<?php

class Model_Main
{
    public function get_data()
    {
        $data = array(
            'errors' => false,
            'message' => '',
            'ordered' => 0,
            'products' => '',
            'cart' => []
        );
        $instance = Database::getinstance();
        $conn = $instance->getconnection();
        if (isset($_POST['to_order']) && isset($_POST['user_name']) && isset($_POST['user_surname']) && isset($_POST['user_email']) && isset($_SESSION['cart'])) {
            require_once('configs/validations.php');
            $user_name = $_POST['user_name'];
            $user_surname = $_POST['user_surname'];
            $user_email = $_POST['user_email'];
            $total = $_POST['total'];
            $valid = new Valid();
            $valid = $valid->user_validation(
                $user_name,
                $user_surname,
                $user_email
            );
            if ($valid == null) {
                $user_rows = 'first_name,last_name,email';
                $insert_user = "'{$user_name}','{$user_surname}','{$user_email}'";
                $insert_query = new Query($conn, 'users', $user_rows, $insert_user);
                $insert_query = $insert_query->insert();
                if ($insert_query) {
                    $user_id = $conn->lastInsertId();
                    $ord_rows = 'user_id,sum';
                    $insert_order = "'{$user_id}','{$total}'";
                    $insert_query = new Query($conn, 'order', $ord_rows, $insert_order);
                    $insert_query = $insert_query->insert();
                    $order_id = $conn->lastInsertId();
                    $ord_rows_p = 'order_id,product_id,qty';
                    foreach ($_SESSION['cart'] as $crt) {
                        $insert_order_p = "'{$order_id}','{$crt[0]}','{$crt[1]}'";
                        $insert_query = new Query($conn, 'order_products', $ord_rows_p, $insert_order_p);
                        $insert_query = $insert_query->insert();
                    }
                    $data['ordered'] = 1;
                    unset($_SESSION['cart']);
                }
            } else {
                $data['errors'] = true;
                $data['message'] = $valid;
            }
        }
        if (isset($_POST['add_cart']) && isset($_POST['prod_id']) && isset($_POST['count'])) {
            if (isset($_SESSION['cart'])) {
                $cart = $_SESSION['cart'];
                $repeat = 0;
                for ($i = 0; $i < count($cart); $i++) {
                    if ($cart[$i][0] == $_POST['prod_id']) {
                        $repeat = 1;
                        $cart[$i][1] += $_POST['count'];
                    }
                }
                if ($repeat == 0) {
                    array_push($cart, [$_POST['prod_id'], $_POST['count']]);
                }
                $_SESSION['cart'] = $cart;
            } else {
                $cart_list = [];
                array_push($cart_list, [$_POST['prod_id'], $_POST['count']]);
                $_SESSION['cart'] = $cart_list;
            }
        }
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            $counter = 0;
            foreach ($cart as $crt) {
                $cart_id = $crt[0];
                $crt_query = new Query($conn, 'products', 'id', $cart_id);
                $get_prds = $crt_query->select();
                foreach ($get_prds as $prod) {
                    $data['cart'][$counter] = array(
                        'title' => $prod['name'],
                        'count' => $crt[1],
                        'price' => $prod['price']
                    );
                }
                $counter++;
            }
        }
        $query = new Query($conn, 'products',);
        $query = $query->select();
        $data['products'] = $query;
        return $data;
    }
}