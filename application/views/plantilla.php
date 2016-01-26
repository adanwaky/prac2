<!DOCTYPE html>
<html lang="en">
    <head>
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
                            <div class="shop-menu pull-right">
                                <ul class="nav navbar-nav">
                                    <li><a href="#"><i class="fa fa-user"></i> Cuenta</a></li>
                                    <li><?php echo anchor('Detalle/mostrarCarrito', '<i class="fa fa-shopping-cart"></i>Carrito')?></li>
                                    <li><?php echo anchor('Login/index', '<i class="fa fa-lock"></i>Login')?></li>
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
                                            <li><?php echo anchor('Cart/index', 'Carrito')?></li>
                                            <li><?php echo anchor('Login/index', 'Login')?></li>
                                        </ul>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!--div class="col-sm-3">
                                <div class="search_box pull-right">
                                        <input type="text" placeholder="Search"/>
                                </div>
                        </div-->
                    </div>
                </div>
            </div><!--/header-bottom-->
        </header><!--/header-->

        <?php foreach ($cuerpo as $cue){
        echo $cue;}
      
        ?>

        <footer id="footer"><!--Footer-->


            <div class="footer-widget">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="single-widget">
                                <h2>Service</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="#">Online Help</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                    <li><a href="#">Order Status</a></li>
                                    <li><a href="#">Change Location</a></li>
                                    <li><a href="#">FAQ’s</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="single-widget">
                                <h2>Quock Shop</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="#">T-Shirt</a></li>
                                    <li><a href="#">Mens</a></li>
                                    <li><a href="#">Womens</a></li>
                                    <li><a href="#">Gift Cards</a></li>
                                    <li><a href="#">Shoes</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="single-widget">
                                <h2>Policies</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="#">Terms of Use</a></li>
                                    <li><a href="#">Privecy Policy</a></li>
                                    <li><a href="#">Refund Policy</a></li>
                                    <li><a href="#">Billing System</a></li>
                                    <li><a href="#">Ticket System</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="single-widget">
                                <h2>About Shopper</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="#">Company Information</a></li>
                                    <li><a href="#">Careers</a></li>
                                    <li><a href="#">Store Location</a></li>
                                    <li><a href="#">Affillate Program</a></li>
                                    <li><a href="#">Copyright</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-3 col-sm-offset-1">
                            <div class="single-widget">
                                <h2>About Shopper</h2>
                                <form action="#" class="searchform">
                                    <input type="text" placeholder="Your email address" />
                                    <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                    <p>Get the most recent updates from <br />our site and be updated your self...</p>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <p class="pull-center">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>

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

