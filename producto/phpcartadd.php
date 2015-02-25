<?php

function autoload($clase) {
    require '../clases/' . $clase . '.php';
}

spl_autoload_register('autoload');
$id = Leer::get("id");
 //añadir el producto a la cesta
session_start();
if (isset($_SESSION["__cesta"])) {
    $cesta = $_SESSION["__cesta"];
} else {
    $_SESSION["__cesta"] = array();
    $cesta = $_SESSION["__cesta"];
}
$bd = new BaseDatos();
$modelo = new ModeloProducto($bd);
$producto = $modelo->get($id);
$return = Leer::get("return");

if (isset($cesta[$id])) {

    $lineacesta = $cesta[$id];
    $lineacesta->setCantidad($lineacesta->getCantidad() + 1);
 
} else {

    $lineacesta = new DetalleVenta(null, null, $id, 1, null, null, null);

    $cesta[$id] = $lineacesta;
}

$_SESSION["__cesta"] = $cesta;

if ($return == "2") {
    header("Location: realizarcompra.php");
} else if ($return == "1"){
    header("Location: ../cart.php");
} else{
    header("Location: ../index.php");
}
