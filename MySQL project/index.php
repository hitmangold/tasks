<?php
require_once('assets/autoload.php');
$page = 0;
$errors = false;
$ordered = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
if (isset($_GET['to_order']) and isset($_SESSION['cart'])) {
    $name = $_GET['user-name'];
    $surname = $_GET['user-surname'];
    $email = $_GET['user-email'];
    $total = $_GET['total'];
    $valid = new Valid();
    $valid = $valid->user_validation(
        $name,
        $surname,
        $email
    );
    if ($valid == null) {
        $user_rows = 'first_name,last_name,email';
        $insert_user = "'{$name}','{$surname}','{$email}'";
        $insert_query = new Requests($conn, 'users', $user_rows, $insert_user);
        $insert_query = $insert_query->insert();
        if ($insert_query) {
            $user_id = $conn->lastInsertId();
            $ord_rows = 'user_id,sum';
            $insert_order = "'{$user_id}','{$total}'";
            $insert_query = new Requests($conn, 'order', $ord_rows, $insert_order);
            $insert_query = $insert_query->insert();
            $order_id = $conn->lastInsertId();
            $ord_rows_p = 'order_id,product_id,qty';
            foreach ($_SESSION['cart'] as $crt) {
                $insert_order_p = "'{$order_id}','{$crt[0]}','{$crt[1]}'";
                $insert_query = new Requests($conn, 'order_products', $ord_rows_p, $insert_order_p);
                $insert_query = $insert_query->insert();
            }
            $ordered = 1;
            unset($_SESSION['cart']);
        }
    } else {
        $errors = true;
    }
}
if (isset($_GET['add_cart']) and isset($_GET['prod_id']) and isset($_GET['count'])) {
    if (isset($_SESSION['cart'])) {
        $cart = $_SESSION['cart'];
        $repeat = 0;
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i][0] == $_GET['prod_id']) {
                $repeat = 1;
                $cart[$i][1] += $_GET['count'];
            }
        }
        if ($repeat == 0) {
            array_push($cart, [$_GET['prod_id'], $_GET['count']]);
        }
        $_SESSION['cart'] = $cart;
    } else {
        $cart_list = [];
        array_push($cart_list, [$_GET['prod_id'], $_GET['count']]);
        $_SESSION['cart'] = $cart_list;
    }
}
if (isset($_GET['add_product']) and isset($_GET['name_product']) and isset($_GET['price_product']) and isset($_GET['description_product'])) {
    $name_product = $_GET['name_product'];
    $price_product = $_GET['price_product'];
    $description_product = $_GET['description_product'];
    $valid = new Valid();
    $valid = $valid->product_validation(
        $name_product,
        $description_product,
        $price_product
    );
    if ($valid == null) {
        $prd_rows = 'name,description,price';
        $insert_prd = "'{$name_product}','{$description_product}','{$price_product}'";
        $insert_query = new Requests($conn, 'products', $prd_rows, $insert_prd);
        $insert_query->insert();
    } else {
        $errors = true;
        $page = 2;
    }
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="scripts/main.js"></script>
    <title>MySQL project</title>
</head>
<body>
<?php
if ($ordered == 1) {
    ?>
    <div class="modal success_ordered" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" align="center">
                    <img src="images/success.png" width="250px">
                    <p style="font-weight: 500;">???????????????????????????????? ?????????????????? ??????????, ?????? ?????????????? ?????????????????? ??</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on("ready", function () {
            $(".success_ordered").modal("show");
        });
    </script>
    <?php
    $ordered = 0;
}
?>
<div class="cart" <?php if (isset($_SESSION['cart'])) { ?> style="display: block;" <?php } ?>>
    <table>
        <tr>
            <th>??????????????????</th>
            <th>????????????</th>
            <th>????????</th>
        </tr>
        <?php
        $total_price = 0;
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            foreach ($cart as $crt) {
                $cart_id = $crt[0];
                $crt_query = new Requests($conn, 'products', 'id', $cart_id);
                $get_carts = $crt_query->select();
                foreach ($get_carts as $info_carts) {
                    ?>
                    <tr>
                        <td><?= $info_carts['name'] ?></td>
                        <td><?= $crt[1] ?></td>
                        <td><?= $info_carts['price'] ?>$</td>
                    </tr>
                    <?php
                    $total_price += $info_carts['price'] * $crt[1];
                }
            }
        }
        ?>
    </table>
    <div style="text-align: right; margin-right: 10px; margin-top: 10px;">
        <p style="font-size: 17px; font-weight: 500;">??????????????????: <?= $total_price ?>$</p>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="index.php" method="get">
                    <input type="text" placeholder="???????? ?????? ????????????" name="user-name"
                           style="width: 100%; height: 35px; border: 1px solid gray; width: 100%; outline: none!important; border-radius: 5px;">
                    <input type="text" placeholder="???????? ?????? ??????????????????" name="user-surname"
                           style="width: 100%; height: 35px; margin-top: 5px; border: 1px solid gray; width: 100%; outline: none!important; border-radius: 5px;">
                    <input type="text" placeholder="???????? ?????? E-mail??" name="user-email"
                           style="width: 100%; height: 35px; margin-top: 5px; border: 1px solid gray; width: 100%; outline: none!important; border-radius: 5px;">
                    <input type="hidden" name="total" value="<?= $total_price ?>">
                    <input value="????????????????" name="to_order" class="btn btn-primary to_cart" type="submit">
                </form>
            </div>
        </div>
    </div>
    <?php
    if ($errors == true) {
        ?>
        <p style="color: red;"><?= $valid ?></p>
        <?php
    }
    ?>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Products</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item <?php if ($page == 0) { ?> active <?php } ?>">
                            <a class="nav-link" href="index.php">?????????????? <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item <?php if ($page == 2) { ?> active <?php } ?>">
                            <a class="nav-link" href="index.php?page=2">?????????????????? ????????????</a>
                        </li>
                        <li class="nav-item <?php if ($page == 3) { ?> active <?php } ?>">
                            <a class="nav-link" href="index.php?page=3">?????????? ?????????? ????????????????????</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <?php
        if ($page == 0) {
            ?>
            <div class="col-md-12">
                <h1>Products</h1>
            </div>
            <?php
            $prd_query = new Requests($conn, 'products');
            $get_products = $prd_query->select();
            foreach ($get_products as $prd) {
                ?>
                <div class="col-md-3" style="margin-top: 10px;">
                    <div class="section_products">
                        <img src="images/image_preview.png" width="100%" height="auto">
                        <div style="padding-left: 10px; margin-top: 10px; margin-bottom: 10px;">
                            <form action="index.php" method="get">
                                <p class="price" data-price="<?= $prd['price'] ?>" style="font-weight: bold;">
                                    ????????: <?= $prd['price'] ?>$</p>
                                <h4 class="title_prod"><?= $prd['name'] ?></h4>
                                <p class="description_prod"><?= $prd['description'] ?></p>
                                <input type="hidden" name="prod_id" value="<?= $prd['id'] ?>">
                                <select name="count">
                                    <option value="1">1 ??????</option>
                                    <option value="2">2 ??????</option>
                                    <option value="3">3 ??????</option>
                                    <option value="4">4 ??????</option>
                                    <option value="5">5 ??????</option>
                                </select>
                                <input value="?????????????????? ??????????????????????" name="add_cart" class="btn btn-primary to_cart"
                                       type="submit">
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } elseif ($page == 2) {
            if ($errors == true) {
                ?>
                <p style="color: red;"><?= $valid ?></p>
                <?php
            }
            ?>
            <div class="col-md-12">
                <h1>?????????????????? ????????????</h1>
            </div>
            <div class="col-md-12" style="margin-top: 20px;">
                <form action="index.php" method="GET">
                    <input type="text" placeholder="??????????????????" name="name_product"
                           style="width: 500px; height: 40px; border: 1px solid lightslategray; border-radius: 5px; outline: none!important; padding-left: 10px;"><br>
                    <input type="text" placeholder="????????" name="price_product"
                           style="margin-top: 20px; width: 500px; height: 40px; border: 1px solid lightslategray; border-radius: 5px; outline: none!important; padding-left: 10px;"><br>
                    <textarea placeholder="??????????????????????????????" name="description_product"
                              style="margin-top: 20px; width: 500px; height: 100px; border: 1px solid lightslategray; border-radius: 5px; outline: none!important; padding-left: 10px;"></textarea><br>
                    <input class="btn btn-primary" value="??????????????????" type="submit" name="add_product"
                           style="margin-top: 20px;">
            </div>
            <?php
        }
        elseif ($page == 3) {
        ?>
        <table>
            <tr>
                <th>
                    ?????????????? ????????????
                </th>
                <th>
                    ?????????????????????? ????????????
                </th>
                <th>
                    ?????????????? ????????????
                </th>
                <th>
                    ?????????????? ????????????????
                </th>
                <!--<th>
                    ??????????????????????????
                </th>-->
            </tr>
            <?php
            $all_orders = new Requests($conn, 'order');
            $get_orders_query = $all_orders->select();
            foreach ($get_orders_query as $ord) {
                ?>
                <tr>
                    <td><?= $ord['id'] ?></td>
                    <td><?= $ord['user_id'] ?></td>
                    <td><?= $ord['sum'] ?>$</td>
                    <td><?= $ord['order_date'] ?></td>
                    <!--<td class="see_more" data-id="">???????????? ????????????</td>-->
                </tr>
                <?php
            }
            ?>
            <?php
            }
            ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
        crossorigin="anonymous"></script>
</body>
</html>