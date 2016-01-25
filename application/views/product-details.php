
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-9 padding-right">
                <div class="product-details"><!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <img src="<?= base_url() . 'assets/img/' . $pro[0]['imagen'] ?>" alt="" />								
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="miproducto-information"><!--/product-information-->
                            <img src="<?= base_url() . 'assets/' ?>images/product-details/new.jpg" class="newarrival" alt="" />
                            <h2 class=""><?= $pro[0]['nombrePro'] ?></h2>
                            <p class="">Web ID: <?= $pro[0]['idPro'] ?></p>
                            <p> Descripción: <?= $pro[0]['descripcionPro'] ?></p><br>
                            <span><?= $pro[0]['precio'] ?> €</span>
                            <?php if ($pro[0]['stock'] > 0){?>
                            <form method="post">
                                <label>Cantidad:</label> 
                                <input type="text" value="1" name="cant" size="2">
                                <input type="hidden" name="img" value="<?=$pro[0]['imagen']?>">
                                <input type="hidden" name="nombre" value="<?=$pro[0]['nombrePro']?>">
                                <input type="hidden" name="precio" value="<?=$pro[0]['precio']?>">
                                <input type="hidden" name="id" value="<?=$pro[0]['idPro']?>">
                                <input type="submit" name="add" 
                                       class="btn btn-fefault cart"  
                                       value='Añadir al carrito'>                                
                            </form>
                            <?php }?>
                            <br>
                            <p><b>Disponibilidad:</b> 
                                <?php echo ($pro[0]['stock'] > 0) ? "En Stock" : "No disponible" ?></p>
                        </div><!--/product-information-->
                    </div>
                </div><!--/product-details-->
            </div>
        </div>
    </div>
</section>