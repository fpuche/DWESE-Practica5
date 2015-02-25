<?php

require '../require/comun.php';
$sesion->autentificado("../index.php");
$u = $sesion->getUsuario();


$pagina = 0;
if (Leer::get("pagina") != null) {
    $pagina = Leer::get("pagina");
}
$bd = new BaseDatos();
$modeloventa = new ModeloVenta($bd);
$ventas = $modeloventa->getList($pagina);
$paginas = $modeloventa->getNumeroPaginas();
$total = $modeloventa->count();
$enlaces = Util::getEnlacesPaginacion2($pagina, $total[0]);
$modelopay = new ModeloPaypal($bd);
$modelodetalle = new ModeloDetalleVenta($bd);
$detalles = $modelodetalle->getList();
$modeloproducto = new ModeloProducto($bd);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Contact | E-Sport</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/font-awesome.min.css" rel="stylesheet">
        <link href="../css/prettyPhoto.css" rel="stylesheet">
        <link href="../css/price-range.css" rel="stylesheet">
        <link href="../css/animate.css" rel="stylesheet">
        <link href="../css/main.css" rel="stylesheet">
        <link href="../css/responsive.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->       
        <link rel="shortcut icon" href="../images/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../images/ico/apple-touch-icon-57-precomposed.png">
    </head><!--/head-->

    <body>
        <header id="header"><!--header-->
            <div class="header_top"><!--header_top-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="contactinfo">
                                <ul class="nav nav-pills">
                                    <li><a href=""><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
                                    <li><a href=""><i class="fa fa-envelope"></i> info@domain.com</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="social-icons pull-right">
                                <ul class="nav navbar-nav">
                                    <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                    <li><a href=""><i class="fa fa-twitter"></i></a></li>
                                    <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href=""><i class="fa fa-dribbble"></i></a></li>
                                    <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/header_top-->

            <div class="header-middle"><!--header-middle-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="logo pull-left">
                                <a href="index.html"><img src="../images/home/logo.png" alt="" /></a>
                            </div>
                            <div class="btn-group pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                        USA
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="">Canada</a></li>
                                        <li><a href="">UK</a></li>
                                    </ul>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                        DOLLAR
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="">Canadian Dollar</a></li>
                                        <li><a href="">Pound</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="shop-menu pull-right">
                                <ul class="nav navbar-nav">
                                    <li><a href=""><i class="fa fa-user"></i> Account</a></li>
                                    <li><a href=""><i class="fa fa-star"></i> Wishlist</a></li>
                                    <li><a href="phpLogout.php"><i class="fa fa-crosshairs"></i> Logout</a></li>
                                    <li><a href="cart.html"><i class="fa fa-shopping-cart"></i> Cart</a></li>
                                    <li><a href="login.html"><i class="fa fa-lock"></i> Login</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/header-middle-->
        </header><!--/header-->

        <div id="contact-page" class="container">
            <div class="bg"> 	
                <div class="row">    		
                    <div class="col-sm-12">    			   			
                        <section id="cart_items">
                            <div class="container">
                                <div class="table-responsive cart_info">
                                    <table class="table table-condensed">
                                        <?php
                                        foreach ($ventas as $indice => $valor) {
                                            $idv = $valor->getId();
                                            ?>
                                            <thead>
                                                <tr class="cart_menu">
                                                    <td class="price">Nº Venta</td>
                                                    <td class="price">Fecha</td>
                                                    <td class="price">Hora</td>
                                                    <td class="description">Cliente</td>
                                                    <td class="description">Dir. Cliente</td>
                                                    <td class="price">PVP</td>
                                                    <td class="price">Item Name Paypal</td>
                                                    <td class="description">Verificación Paypal</td>
                                                    <td class="description">Pagado</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="cart_price"><?php echo $valor->getId(); ?></td>
                                                    <td class="cart_price"><?php echo $valor->getFecha(); ?></td>
                                                    <td class="cart_price"><?php echo $valor->getHora(); ?></td>
                                                    <td class="cart_description"><?php echo $valor->getNombreUsuario(); ?></td>
                                                    <td class="cart_description"><?php echo $valor->getDirUsuario(); ?></td>
                                                    <td class="cart_price"><?php echo $valor->getPrecioTotal(); ?></td>
                                                    <td class="cart_description"><?php echo $modelopay->getPorItemName($valor->getId())->getItemname(); ?></td>
                                                    <td class="cart_description"><?php echo $modelopay->getPorItemName($valor->getId())->getVerifica(); ?></td>
                                                    <td class="cart_description"><?php echo $valor->getPago(); ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="9" style="background-color:#A4A3A6;" >Líneas de venta </td>
                                                </tr>
                                                <tr style="background-color:#E5E4E8;">
                                                    <td>Id Detalle Venta</td>
                                                    <td>Id Producto</td>
                                                    <td>Nombre Producto</td>
                                                    <td>Cantidad</td>
                                                    <td>PVP</td>
                                                    <td>IVA</td>
                                                    <td colspan="3">Total</td>

                                                </tr>

                                                <?php
                                                foreach ($detalles as $key => $detalle) {
                                                    $iddv = $detalle->getIdVenta();
                                                    if ($iddv == $idv) {
                                                        ?>                  
                                                        <tr>
                                                            <td class="cart_quantity"><?php echo $detalle->getId(); ?></td>
                                                            <td class="cart_quantity"><?php echo $detalle->getIdProducto(); ?></td>
                                                            <td class="cart_description"><?php echo $modeloproducto->get($detalle->getIdProducto())->getNombreProducto(); ?></td>
                                                            <td class="cart_quantity"><?php echo $detalle->getCantidad(); ?></td>
                                                            <td class="cart_quantity"><?php echo $detalle->getPrecioVenta(); ?></td>
                                                            <td class="cart_quantity"><?php echo $detalle->getIvaVenta(); ?></td>
                                                            <?php
                                                            $precio = $detalle->getPrecioVenta();
                                                            $cantidad = $detalle->getCantidad();
                                                            ?>
                                                            <td class="cart_quantity"><?php echo $precio * $cantidad ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php
                                            }
                                            ?>    
                                            <tr >
                                                <td class="price" class="paginacion" colspan="9" style="background-color:#E5E4E8; color: black; text-align: center;">
                                                    <?php echo $enlaces["inicio"]; ?>
                                                    <?php echo $enlaces["anterior"]; ?>
                                                    <?php echo $enlaces["primero"]; ?>
                                                    <?php echo $enlaces["segundo"]; ?>
                                                    <?php echo $enlaces["actual"]; ?>
                                                    <?php echo $enlaces["cuarto"]; ?>
                                                    <?php echo $enlaces["quinto"]; ?>
                                                    <?php echo $enlaces["siguiente"]; ?>
                                                    <?php echo $enlaces["ultimo"]; ?>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                        </section> <!--/#cart_items-->
                    </div>			 		
                </div>   
            </div>	
        </div><!--/#contact-page-->

        <footer id="footer"><!--Footer-->
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="companyinfo">
                                <h2><span>e</span>-shopper</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="col-sm-3">
                                <div class="video-gallery text-center">
                                    <a href="#">
                                        <div class="iframe-img">
                                            <img src="../images/home/iframe1.png" alt="" />
                                        </div>
                                        <div class="overlay-icon">
                                            <i class="fa fa-play-circle-o"></i>
                                        </div>
                                    </a>
                                    <p>Circle of Hands</p>
                                    <h2>24 DEC 2014</h2>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="video-gallery text-center">
                                    <a href="#">
                                        <div class="iframe-img">
                                            <img src="../images/home/iframe2.png" alt="" />
                                        </div>
                                        <div class="overlay-icon">
                                            <i class="fa fa-play-circle-o"></i>
                                        </div>
                                    </a>
                                    <p>Circle of Hands</p>
                                    <h2>24 DEC 2014</h2>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="video-gallery text-center">
                                    <a href="#">
                                        <div class="iframe-img">
                                            <img src="../images/home/iframe3.png" alt="" />
                                        </div>
                                        <div class="overlay-icon">
                                            <i class="fa fa-play-circle-o"></i>
                                        </div>
                                    </a>
                                    <p>Circle of Hands</p>
                                    <h2>24 DEC 2014</h2>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="video-gallery text-center">
                                    <a href="#">
                                        <div class="iframe-img">
                                            <img src="../images/home/iframe4.png" alt="" />
                                        </div>
                                        <div class="overlay-icon">
                                            <i class="fa fa-play-circle-o"></i>
                                        </div>
                                    </a>
                                    <p>Circle of Hands</p>
                                    <h2>24 DEC 2014</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="address">
                                <img src="../images/home/map.png" alt="" />
                                <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-widget">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="single-widget">
                                <h2>Service</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="">Online Help</a></li>
                                    <li><a href="">Contact Us</a></li>
                                    <li><a href="">Order Status</a></li>
                                    <li><a href="">Change Location</a></li>
                                    <li><a href="">FAQ’s</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="single-widget">
                                <h2>Quock Shop</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="">T-Shirt</a></li>
                                    <li><a href="">Mens</a></li>
                                    <li><a href="">Womens</a></li>
                                    <li><a href="">Gift Cards</a></li>
                                    <li><a href="">Shoes</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="single-widget">
                                <h2>Policies</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="">Terms of Use</a></li>
                                    <li><a href="">Privecy Policy</a></li>
                                    <li><a href="">Refund Policy</a></li>
                                    <li><a href="">Billing System</a></li>
                                    <li><a href="">Ticket System</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="single-widget">
                                <h2>About Shopper</h2>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="">Company Information</a></li>
                                    <li><a href="">Careers</a></li>
                                    <li><a href="">Store Location</a></li>
                                    <li><a href="">Affillate Program</a></li>
                                    <li><a href="">Copyright</a></li>
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
                        <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
                        <p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
                    </div>
                </div>
            </div>

        </footer><!--/Footer-->



        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
<!--        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="../js/gmaps.js"></script>-->
        <script src="../js/contact.js"></script>
        <script src="../js/price-range.js"></script>
        <script src="../js/jquery.scrollUp.min.js"></script>
        <script src="../js/jquery.prettyPhoto.js"></script>
        <script src="../js/main.js"></script>
    </body>
</html>