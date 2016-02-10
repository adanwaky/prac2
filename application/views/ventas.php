<form method="post">
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><a href="<?= base_url()?>index.php/Pedidos/MostrarPedidos">Pedidos</a></li>
                    <li class="active">Ventas</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Producto</td>
                            <td class="description">Descripción</td>
                            <td class="quantity">Cantidad</td>
                            <td class="total">Total</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($ventas as $pro) {
                            ?>
                            <tr>
                                <td class="cart_product">
                                    <a href=""><img src="<?= base_url() . 'assets/img/' . $pro['img'] ?>" alt=""></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href=""><?= $pro['nombre'] ?></a></h4>
                                </td>
                                <td class="cart_price">
                                    <p><?= $pro['unidades'] ?></p>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">
                                        <?=
                                        $pro['precio']
                                        ?>€
                                    </p>
                                </td>
                                
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->
</form><!--/#do_action-->
