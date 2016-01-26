    <section>
       
        
                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">PRODUCTOS</h2>
                        <?php foreach ($pro as $producto) {?> 
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                       <?php echo anchor('detalle/index/'.$producto['idPro'],'  
                                <img src= "'.base_url() . 'assets/img/' . $producto['imagen'].'"/>')?>
                                        <!--img src="<?= base_url() . 'assets/img/'.$producto['imagen']?>" alt="" /-->
                                        <h2><?= $producto['precio'] ?> €</h2>
                                            <p><?= $producto['nombrePro'] ?></p>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <?php }?>
                        
                        <!--ul class="pagination">
                            <li class="active"><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">&raquo;</a></li>
                        </ul-->
                       
                    </div><!--features_items--><?=$paginacion?>
                </div>
         
            </div>
        </div>
    </section>
