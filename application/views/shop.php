<section>
    <div class="col-sm-9 padding-right">
        <div class="features_items"><!--features_items-->
            <h2 class="title text-center">PRODUCTOS</h2>
            <?php foreach ($pro as $producto) { ?> 
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <?php echo anchor('detalle/index/' . $producto['idPro'], '  
                                <img class="img-responsive"  src= "' . base_url() . 'assets/img/' . $producto['imagen'] . '"/>') ?>
                                <h2><?= number_format($producto['precio'] * (float) $_SESSION['tarifa'], 2, '.', '' ). ' ' . $_SESSION['moneda'] ?></h2>
                                <p><?= $producto['nombrePro'] ?></p>
                                <?php if ($producto['stock'] > 0) { ?>
                                    <a href="<?= base_url() ?>index.php/Cart/guardar/<?= $producto['idPro'] ?>"
                                       class="btn btn-default add-to-cart">
                                        <i class="fa fa-shopping-cart"></i>Añadir al carrito</a>
                                    <?php } else {
                                        echo 'No disponible';
                                    } ?>
                            </div>

                        </div>
                    </div>
                </div>
<?php } ?>
        </div><!--features_items--><?= $paginacion ?>
    </div>

</div>
</div>
</section>
