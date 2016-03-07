<?php if ($carro == null) { ?>
<center><div><p style='color:blue;font-weight: bold;'> No hay productos en el carrito</p></div></center>
                        <?php
                    } else {?>
<form method="post">
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li class="active">Carrito de compra</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Producto</td>
                            <td class="description">Descripción</td>
                            <td class="price">Precio</td>
                            <td class="quantity">Cantidad</td>
                            <td class="total">Total</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if ($mensaje != null) {
                            echo "<p style='color:red; font-weight: bold;'> No hay suficiente stock</p>";
                        }
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
                                        <input type="number" name="<?=$pro['id']?>" value="<?=$pro['unidades']?>" min="1">
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
                    ?>
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
                            <li>Total <span><?=number_format($euros * (float) $_SESSION['tarifa'],2, '.','' ). ' ' . $_SESSION['moneda']?></span></li>
                            
                        </ul>
                        <input type="submit" name="upd" 
                               class="btn btn-default check_out"  
                               value='Actualizar'>    

                        <input type="submit" name="comprar" 
                               class="btn btn-default check_out"  
                               value='Comprar'> 
                    </div>
                </div>
            </div>
        </div>
    </section>   
</form><!--/#do_action-->

 <?php } ?>