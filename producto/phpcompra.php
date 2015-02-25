<?php

require '../require/comun.php';

$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);
$precioTotal=0;
if (isset($_SESSION["__cesta"])) {
    $cesta = $_SESSION["__cesta"];
    $precio = 0;
    foreach ($cesta as $key => $linea) {
        $precio = $precio + ($linea->getCantidad() * $modelo->get($linea->getIdProducto())->getPrecioProducto());        
    }
    $precioTotal = $precioTotal + $precio;
}
echo $precioTotal;
$nombre = Leer::post("nombre");
$direccion = Leer::post("direccion");
$modeloventa = new ModeloVenta($bd);
date_default_timezone_set('Europe/Paris');
$fecha = date("d.m.y");
$hora = date("H:i:s");
$pago = "no";
$venta = new Venta(null, $fecha, $hora, $pago, $nombre, $direccion, $precioTotal);
$modeloventa->add($venta);
$idVenta = $bd->getAutonumerico();
$modeloDetalle = new ModeloDetalleVenta($bd);
if (isset($_SESSION["__cesta"])) {
    $cesta = $_SESSION["__cesta"];
    foreach ($cesta as $key => $linea) {
        $idproducto = $modelo->get($linea->getIdProducto())->getId();
        $cantidad = $linea->getCantidad();
        $precio = $modelo->get($linea->getIdProducto())->getPrecioProducto();
        $iva = $modelo->get($linea->getIdProducto())->getIvaProducto();
        $detalle = new DetalleVenta(null, $idVenta, $idproducto, $cantidad, $precio, $iva);
        $modeloDetalle->add($detalle);
    }
}
header("Location: comprarpaypal.php?id=$idVenta&cliente=$nombre");
?>
