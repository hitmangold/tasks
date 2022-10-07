<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Ավելացնել ապրանք</h1>
        </div>
        <div class="col-md-12" style="margin-top: 20px;">
            <form action="add" method="POST">
                <input type="text" placeholder="Անվանումը" name="name_product"
                       style="width: 500px; height: 40px; border: 1px solid lightslategray; border-radius: 5px; outline: none!important; padding-left: 10px;"><br>
                <input type="text" placeholder="Գինը" name="price_product"
                       style="margin-top: 20px; width: 500px; height: 40px; border: 1px solid lightslategray; border-radius: 5px; outline: none!important; padding-left: 10px;"><br>
                <textarea placeholder="Նկարագրությունը" name="description_product"
                          style="margin-top: 20px; width: 500px; height: 100px; border: 1px solid lightslategray; border-radius: 5px; outline: none!important; padding-left: 10px;"></textarea><br>
                <input class="btn btn-primary" value="Ավելացնել" type="submit" name="add_product"
                       style="margin-top: 20px;">
        </div>
        <?php
        if ($data['errors'] == true) {
            ?>
            <div class="col-md-12"><p style="color:red;"><?= $data['message'] ?></p></div>
            <?php
        }
        ?>
    </div>
</div>
