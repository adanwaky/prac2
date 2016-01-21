<section>
    <div class="col-sm-9 padding-right">
        <div class="features_items"><!--features_items-->
            <h2 class="title text-center">Productos destacados</h2>
            <?php foreach ($pro as $producto) { ?> 
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <?php echo anchor('detalle/index/'.$producto['idPro'],'  
                                <img src= "'.base_url() . 'assets/img/' . $producto['imagen'].'"/>')?>
                                
                                <h2><?= $producto['precio'] ?> €</h2>
                                <p><?= $producto['nombrePro'] ?></p>
                                <a href="#" class="btn btn-default add-to-cart">
                                    <i class="fa fa-shopping-cart"></i>Add to cart</a>
                            </div>
                            
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div><!--features_items-->
        
    </div><!--/category-tab-->
</div>
</div>
</div>
</section>


