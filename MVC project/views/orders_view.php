<div class="container">
    <div class="row">
        <table>
            <tr>
                <th>
                    Պատվերի համարը
                </th>
                <th>
                    Պատվիրատուի համարը
                </th>
                <th>
                    Պատվերի արժեքը
                </th>
                <th>
                    Պատվերի ամսաթիվը
                </th>
                <!--<th>
                    Գործողություն
                </th>-->
            </tr>
            <?php
            foreach ($data as $ord) {
                ?>
                <tr>
                    <td><?= $ord['id'] ?></td>
                    <td><?= $ord['user_id'] ?></td>
                    <td><?= $ord['sum'] ?>$</td>
                    <td><?= $ord['order_date'] ?></td>
                    <!--<td class="see_more" data-id="">Տեսնել ավելին</td>-->
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>