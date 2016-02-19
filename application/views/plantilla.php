<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" type="image/png" href="<?= base_url() . 'assets/' ?>img/favicon.png" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>MERCAROCHE</title>
        <link href="<?= base_url() . 'assets/' ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url() . 'assets/' ?>css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= base_url() . 'assets/' ?>css/prettyPhoto.css" rel="stylesheet">
        <link href="<?= base_url() . 'assets/' ?>css/price-range.css" rel="stylesheet">
        <link href="<?= base_url() . 'assets/' ?>css/animate.css" rel="stylesheet">
        <link href="<?= base_url() . 'assets/' ?>css/main.css" rel="stylesheet">
        <link href="<?= base_url() . 'assets/' ?>css/responsive.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="<?= base_url() . 'assets/' ?>js/html5shiv.js"></script>
        <script src="<?= base_url() . 'assets/' ?>js/respond.min.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="<?= base_url() . 'assets/' ?>images/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url() . 'assets/' ?>images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url() . 'assets/' ?>images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url() . 'assets/' ?>images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="<?= base_url() . 'assets/' ?>images/ico/apple-touch-icon-57-precomposed.png">
    </head><!--/head-->

    <body>
        <header id="header"><!--header-->

            <div class="header-middle"><!--header-middle-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="logo pull-left">
                                <a href="<?= base_url() ?>"><img src="<?= base_url() . 'assets/' ?>images/home/logo.png" alt="" /></a>
                            </div>

                        </div>

                        <div class="col-sm-8">
                            <div class="btn-group pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                        <?php echo $_SESSION['moneda'] ?>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php

                                        function creaSelectMoneda() {
                                            $fecha = date('Y-m-d');
                                            $filename = '././assets/xml_monedas/' . $fecha . '-moneda.xml';
                                            if (file_exists('./assets/xml_monedas/' . $fecha . '-moneda.xml')) {
                                                $XML = simplexml_load_file('./assets/xml_monedas/' . $fecha . '-moneda.xml');
                                            } else {
                                                $cadena = file_get_contents("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
                                                file_put_contents($filename, $cadena);
                                                $XML = simplexml_load_file('./assets/xml_monedas/' . $fecha . '-moneda.xml');
                                            }
                                            foreach ($XML->Cube->Cube->Cube as $rate) {
                                                echo "<li>";
                                                echo "<a href=" . base_url() . 'index.php/Welcome/cambiarTarifa/' . $rate['currency'] . ">" . $rate['currency'] . "</a>";
                                                echo "</li>";
                                            }
                                        }

                                        echo "<li><a href=" . base_url() . 'index.php/Welcome/cambiarTarifa/EUR' . "> EUR</a></li>";
                                        creaSelectMoneda();
                                        ?>
                                    </ul>
                                </div>


                            </div>
                            <div class="shop-menu pull-right">
                                <ul class="nav navbar-nav collapse navbar-collapse">
                                    <?php if (isset($_SESSION['user'])) { ?>
                                        <li>Hola, <?php echo $_SESSION['nombreUser'] ?>!</li>
                                        <li class="dropdown">
                                            <a href="#"><i class="fa fa-user"></i> Cuenta<i class="fa fa-angle-down"></i></a>
                                            <ul role="menu" class="sub-menu">
                                                <li><?php echo anchor("Login/datosUser", "Datos") ?></li>
                                                <li><?php echo anchor('Pedidos/MostrarPedidos', 'Pedidos') ?></li>
                                                <li><?php echo anchor('Login/CerrarSesion', 'Cerrar Sesión') ?></li>
                                            </ul></li><?php } else { ?>
                                        <li><?php echo anchor('Login/index', '<i class="fa fa-lock"></i>Login') ?></li>
                                    <?php }
                                    ?>
                                    <li><?php echo anchor('Cart/muestraCart', '<i class="fa fa-shopping-cart"></i>Carrito') ?></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/header-middle-->

            <div class="header-bottom"><!--header-bottom-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="mainmenu pull-left">
                                <ul class="nav navbar-nav collapse navbar-collapse">
                                    <li><a href="<?= base_url() ?>" class="active">Home</a></li>
                                    <li class="dropdown"><a href="#">Tienda<i class="fa fa-angle-down"></i></a>
                                        <ul role="menu" class="sub-menu">
                                            <li><?php echo anchor('Cart/muestraCart', 'Carrito') ?></li>
                                            <li><?php echo anchor('Categoria/mostrarTodo', 'Productos') ?></li>
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!--/header-bottom-->
        </header><!--/header-->

        <?php
        foreach ($cuerpo as $cue) {
            echo $cue;
        }
        ?>

        <footer id="footer"><!--Footer-->
            <div class="footer-widget">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="single-widget">
                                <h2><a href="<?= base_url() . 'index.php/ExportarXML/exportar' ?>">Exportar XML</a></h2>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="single-widget">
                                <h2><a href="<?= base_url() . 'index.php/ImportarXML' ?>">Importar XML</a></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <p class="pull-center">Copyright © 2013 MERCAROCHE Inc. Todos los derechos reservados.</p>

                    </div>
                </div>
            </div>

        </footer><!--/Footer-->



        <script src="<?= base_url() . 'assets/' ?>js/jquery.js"></script>
        <script src="<?= base_url() . 'assets/' ?>js/bootstrap.min.js"></script>
        <script src="<?= base_url() . 'assets/' ?>js/jquery.scrollUp.min.js"></script>
        <script src="<?= base_url() . 'assets/' ?>js/price-range.js"></script>
        <script src="<?= base_url() . 'assets/' ?>js/jquery.prettyPhoto.js"></script>
        <script src="<?= base_url() . 'assets/' ?>js/main.js"></script>
    </body>
</html>

