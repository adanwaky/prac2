
<form method="post">
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li class="active">Pedidos</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td class="description">Núm. Pedido</td>
                            <td class="description">Estado</td>
                            <td class="image">Factura</td>
                            <td class="image">Anular</td>
                            <td class="image">Detalles</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if ($pedido == null) { ?>
                        <div> No hay pedidos</div>
                        <?php
                    } else {
                       
                        foreach ($pedido as $pro) {
                            ?>
                            <tr>
                                <td class="cart_description">
                                     <p><?= $pro['idPed'] ?></p> 
                                </td>
                                <td class="cart_description">
                                    <p><?= $pro['estado'] ?></p>
                                </td>
                                <td class="cart_description">
                                    <a href=""><img src="<?= base_url() . 'assets/img/albaran.jpg' ?>" alt=""></a>
                                </td>
                                <td class="cart_description">
                                   <a href=""><img src="<?= base_url() . 'assets/img/detalles.png' ?>" alt=""></a>
                                </td>                                
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete" href="<?= base_url() . 'index.php/Cart/borrar/' . $pro['id'] ?>"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->
</form><!--/#do_action-->


