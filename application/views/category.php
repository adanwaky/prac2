    
 <div class="container">
     <div class="row"></div><div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Categorías</h2>
                        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
<?php foreach ($cat as $categoria) { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"> <?php echo anchor('Categoria/mostrar/'.$categoria['idCat'], $categoria['nombreCat']) ?></h4>
                                </div>
</div> <?php }?>
                            

                        </div>

                    </div>
                </div>