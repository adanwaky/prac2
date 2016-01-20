
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 padding-right">
                <div class="product-details"><!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <img src="<?= base_url() . 'assets/img/'.$pro[0]['imagen'] ?>" alt="" />								
                        </div>


                    </div>
                    <div class="col-sm-7">
                        <div class="product-information"><!--/product-information-->
                            <img src="<?= base_url() . 'assets/' ?>images/product-details/new.jpg" class="newarrival" alt="" />
                            <h2><?= $pro[0]['nombrePro'] ?></h2>
                            <p>Web ID: <?= $pro[0]['idPro'] ?></p>
                            <p> Descripción: <?=$pro[0]['descripcionPro']?>
                            <span>
                                <span><?= $pro[0]['precio'] ?> €</span>
                                <label>Cantidad:</label>
                                <input type="text" value="1" />
                                <button type="button" class="btn btn-fefault cart">
                                    <i class="fa fa-shopping-cart"></i>
                                    Añadir al carrito
                                </button>
                            </span>
                            <p><b>Disponibilidad:</b> <?php echo ($pro[0]['stock'] > 0) ? "En Stock" : "No disponible" ?></p>

                            <a href=""><img src="<?= base_url() . 'assets/' ?>images/product-details/share.png" class="share img-responsive"  alt="" /></a>
                        </div><!--/product-information-->
                    </div>
                </div><!--/product-details-->





            </div>
        </div>
    </div>
</section>