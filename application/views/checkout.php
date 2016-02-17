<body>

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><a href="<?= base_url().'/index.php/Cart/muestraCart' ?>">Carrito</a></li>
                    <li class="active">Check out</li>
                </ol>
            </div><!--/breadcrums-->

            <div class="step-one">
                <h2 class="heading">Resumen</h2>
            </div>

            <div class="shopper-informations">
                <div class="row">
                    <!--div class="col-sm-5 clearfix"-->
                    <div class="shopper-info">
                        <p>Enviar a:</p>

                        <?php
                        echo ($datos[0]['nombreUs'] . ' ' . $datos[0]['apellidos'] . '<br>');
                        echo ($datos[0]['direccion'] . '<br>');
                        echo ($datos[0]['cp'] . ', ' . $provincia[0]['nombre'] . '<br>');
                        ?>
                        <form>             
                            <a class="btn btn-primary" href="<?= base_url() . 'index.php/Login/datosUser' ?>">Cambiar Datos</a>
                        </form>

                    </div>

                    <!--/div-->
                </div>
                <div class="review-payment">
                    <h2>Revisión y condiciones</h2>
                </div>

                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                            <tr class="cart_menu">
                                <td class="image">Producto</td>
                                <td class="description"></td>
                                <td class="price">Precio</td>
                                <td class="quantity">Cantidad</td>
                                <td class="total">Total</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if ($carro == null) { ?>
                            <div> No hay productos en el carrito</div>
                            <?php
                        } else {

                            foreach ($carro as $pro) {
                                ?>
                                <tr>
                                    <td class="cart_product">
                                        <a href=""><img src="<?= base_url() . 'assets/img/' . $pro['img'] ?>" alt=""></a>
                                    </td>
                                    <td class="cart_description">
                                        <h4><a href=""><?= $pro['nombre'] ?></a></h4>
                                        <p>Web ID: <?= $pro['id'] ?></p>
                                    </td>
                                    <td class="cart_price">
                                        <p><?= number_format($pro['precio'] * (float) $_SESSION['tarifa'],2, '.','' ). ' ' . $_SESSION['moneda'] ?></p>
                                    </td>
                                    <td class="cart_quantity">
                                        <div class="cart_quantity_button">
                                            <input type="number" name="<?= $pro['id'] ?>" value="<?= $pro['unidades'] ?>" readonly min="1">
                                        </div>
                                    </td>
                                    <td class="cart_total">
                                        <p class="cart_total_price">
                                            <?=
                                            number_format($pro['total'] * (float) $_SESSION['tarifa'],2, '.','' ). ' ' . $_SESSION['moneda']
                                            ?>
                                        </p>
                                    </td>
                                    <td class="cart_delete">
                                        <a class="cart_quantity_delete" href="<?= base_url() . 'index.php/Cart/borrar/' . $pro['id'] ?>"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td colspan="2">
                                <table class="table table-condensed total-result">
                                    <tr>
                                        <td>Total</td>
                                        <td><?= number_format($euros * (float) $_SESSION['tarifa'],2, '.','' ). ' ' . $_SESSION['moneda']?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>       
                        </tbody>
                    </table>
                </div>
                <div align="right">
                    <a class="btn btn-default check_out"
                       href="<?=base_url()."index.php/Pedidos/Nuevopedido/$euros/".$_SESSION['user']?>">
                        Realizar Pedido</a>
                </div>
                <br><br>
            </div>
        </div>
    </section> <!--/#cart_items-->