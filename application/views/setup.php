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
                                <a href="#"><img src="<?= base_url() . 'assets/' ?>images/home/logo.png" alt="" /></a>
                            </div>

                        </div>

                        <div class="col-sm-8">
                            <div class="btn-group pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                </div>

                            </div>
                            <div class="shop-menu pull-right">
                                <ul class="nav navbar-nav collapse navbar-collapse">
                                    

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
                                    <li><a href="#" class="active">Home</a></li>
                                    <li class="dropdown"><a href="#">Tienda<i class="fa fa-angle-down"></i></a>                                        
                                    </li>

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!--/header-bottom-->
        </header><!--/header-->

       <div class="container">
            <div class="row" >
                <div class="col-sm-4">
                    <div class="signup-form" >
                        <form method="post">
                            Servidor: <input type="text" name="servidor"><br>
                            Usuario: <input type="text" name="usuario"><br>
                            Contraseña: <input type="text" name="pass"><br>
                            Base de datos: <input type="text" name="base_datos"><br>
                            <input type="submit" 
                                   style="background-color:#FF8A02;color:white;"  
                                   value='Cambiar contraseña'> 
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <footer id="footer"><!--Footer-->
            <div class="footer-widget">
                <div class="container">
                    <div class="row">
                       
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

