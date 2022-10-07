<?php
if ($data['ordered'] == 1) {
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
                    <img src="views/images/success.png" width="250px">
                    <p style="font-weight: 500;">Շնորհակալություն գնումների համար, ձեր պատվերը ընդունված է</p>
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
}
?>
<div class="cart" <?php if (isset($_SESSION['cart'])) { ?> style="display: block;" <?php } ?>>
    <table>
        <tr>
            <th>Անվանումը</th>
            <th>Քանակը</th>
            <th>Գինը</th>
        </tr>
        <?php
        $total_price = 0;
        foreach ($data['cart'] as $crt) {
            ?>
            <tr>
                <td><?= $crt['title'] ?></td>
                <td><?= $crt['count'] ?></td>
                <td><?= $crt['price'] ?>$</td>
            </tr>
            <?php
            $total_price += $crt['price'] * $crt['count'];
        }
        ?>
    </table>
    <div style="text-align: right; margin-right: 10px; margin-top: 10px;">
        <p style="font-size: 17px; font-weight: 500;">Ընդհանուր: <?= $total_price ?>$</p>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="index" method="post">
                    <input type="text" placeholder="Նշեք ձեր անունը" name="user_name"
                           style="width: 100%; height: 35px; border: 1px solid gray; width: 100%; outline: none!important; border-radius: 5px;">
                    <input type="text" placeholder="Նշեք ձեր ազգանունը" name="user_surname"
                           style="width: 100%; height: 35px; margin-top: 5px; border: 1px solid gray; width: 100%; outline: none!important; border-radius: 5px;">
                    <input type="text" placeholder="Նշեք ձեր E-mailը" name="user_email"
                           style="width: 100%; height: 35px; margin-top: 5px; border: 1px solid gray; width: 100%; outline: none!important; border-radius: 5px;">
                    <input type="hidden" name="total" value="<?= $total_price ?>">
                    <input value="Պատվիրել" name="to_order" class="btn btn-primary to_cart" type="submit">
                </form>
            </div>
        </div>
    </div>
    <?php
    if ($data['errors'] == true) {
        ?>
        <p style="color: red;"><?= $data['message'] ?></p>
        <?php
    }
    ?>
</div>
<div class="container">
    <div class="row">
        <?php
        foreach ($data['products'] as $prd) {
            ?>
            <div class="col-md-3" style="margin-top: 10px;">
                <div class="section_products">
                    <img src="views/images/image_preview.png" width="100%" height="auto">
                    <div style="padding-left: 10px; margin-top: 10px; margin-bottom: 10px;">
                        <form action="index" method="post">
                            <p class="price" data-price="<?=$prd['price']?>" style="font-weight: bold;">
                                Գինը: <?=$prd['price']?>$</p>
                            <h4 class="title_prod"><?=$prd['name']?></h4>
                            <p class="description_prod"><?=$prd['description']?></p>
                            <input type="hidden" name="prod_id" value="<?=$prd['id']?>">
                            <select name="count">
                                <option value="1">1 հատ</option>
                                <option value="2">2 հատ</option>
                                <option value="3">3 հատ</option>
                                <option value="4">4 հատ</option>
                                <option value="5">5 հատ</option>
                            </select>
                            <input value="Ավելացնել զամբյուղում" name="add_cart" class="btn btn-primary to_cart"
                                   type="submit">
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
