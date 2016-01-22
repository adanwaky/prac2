<body>
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Carrito de compra</li>
                </ol>
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
                        <?php print_r($carro);
                        foreach($carro as $pro){
                        ?>
                        <tr>
                            <td class="cart_product">
                                <a href=""><img src="<?= base_url() . 'assets/' ?>images/cart/one.png" alt=""></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href="">Colorblock Scuba</a></h4>
                                <p>Web ID: 1089772</p>
                            </td>
                            <td class="cart_price">
                                <p>$59</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <a class="cart_quantity_up" href=""> + </a>
                                    <input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
                                    <a class="cart_quantity_down" href=""> - </a>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">$59</p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->

    <section id="do_action">
        <div class="container">
            <div class="row">  
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Subtotal <span>$59</span></li>
                            <li>IVA <span>$2</span></li>
                            <li>Gastos de envío <span>Gratis</span></li>
                            <li>Total <span>$61</span></li>
                        </ul>
                        <a class="btn btn-default update" href="">Actualizar</a>
                        <a class="btn btn-default check_out" href="">Continuar</a>
                    </div>
                </div>
                            </div>
        </div>
    </section><!--/#do_action-->