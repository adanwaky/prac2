<body>

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Check out</li>
                </ol>
            </div><!--/breadcrums-->

            <div class="step-one">
                <h2 class="heading">Resumen</h2>
            </div>

            <div class="shopper-informations">
                <div class="row">
                    <!--div class="col-sm-5 clearfix"-->
                    <div class="bill-to">
                        <p>Facturar a</p>
                        <div class="form-one">
                            <form>             

                                <input type="text" placeholder="Usuario">
                                <input type="text" placeholder="Email">
                                <input type="text" placeholder="DNI">
                                <input type="text" placeholder="Nombre">

                                <input type="text" placeholder="Apellidos">
                                <input type="text" placeholder="Dirección">
                                <input type="text" placeholder="Código Postal">
                                <?php echo form_dropdown('provincias_id', $provincias) ?> 

                            </form>
                        </div>                           
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
                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td colspan="2">
                                    <table class="table table-condensed total-result">
                                        <tr>
                                            <td>Subtotal</td>
                                            <td>$59</td>
                                        </tr>
                                        <tr>
                                            <td>IVA</td>
                                            <td>$2</td>
                                        </tr>
                                        <tr class="shipping-cost">
                                            <td>Gastos de envío</td>
                                            <td>Gratis</td>										
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td><span>$61</span></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>                    
                </div>
                <div align="right">
                <a class="btn btn-default check_out" href="">Realizar Pedido</a>
                </div>
                <br><br>
            </div>
        </div>
    </section> <!--/#cart_items-->