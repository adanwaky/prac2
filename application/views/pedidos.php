
<form method="post">
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li class="active">Pedidos</li>
                </ol>
            </div>
            <?php if(isset($mensaje)) echo "<p style='color:red; font-weight: bold;'>".$mensaje.'</p>';?>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td align="center">Núm. Pedido</td>
                            <td align="center">Estado</td>
                            <td align="center">Factura</td>
                            <td align="center">Detalles</td>
                            <td align="center">Anular</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if ($pedido == null) { ?>
                        <div> No hay pedidos</div>
                        <?php
                    } else {
                       
                        foreach ($pedido as $pro) {
                            ?>
                            <tr>
                                <td align="center" >
                                     <p><?= $pro['idPed'] ?></p> 
                                </td>
                                <td align="center" >
                                    <p><?= $pro['estado'] ?></p>
                                </td>
                                <td align="center" >
                            <a href="<?=base_url().'index.php/pedidos/mostrarFactura/'.$pro['idPed']?>" ><img src="<?= base_url() . 'assets/img/albaran.jpg' ?>" alt=""></a>/
                               <a href="<?=base_url().'index.php/pedidos/descargarFactura/'.$pro['idPed']?>" ><img src="<?= base_url() . 'assets/img/pdf.png' ?>" alt=""></a>
                                </td>
                                <td align="center" >
                                    <a href="<?= base_url().'index.php/pedidos/mostrarVentas/'.$pro['idPed'] ?>"><img src="<?= base_url() . 'assets/img/ver.png' ?>" alt=""></a>
                                </td>                                
                                <td class="cart_delete" align="center" >
                                    <a class="cart_quantity_delete" 
                                       href="<?= base_url().'index.php/pedidos/AnularPedido/'.$pro['idPed'] ?>">
                                        <i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->
</form><!--/#do_action-->


