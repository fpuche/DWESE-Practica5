<?php

require 'require/comun.php';

$bd = new BaseDatos();

$texto = "";
$item_name = "";
$payment_status = "";
$verifica = "";
$respuesta = "";
$pago = "no";

foreach ($_POST as $nombre => $valor) {
    if ($nombre == "item_name") {
        $item_name = $valor;
    }
    if ($nombre == "payment_status") {
        $payment_status = $valor;
    }
    $texto.="$nombre : $valor\n";
}
$texto.="********************************\n";



$req = 'cmd=_notify-validate';
foreach ($_POST as $clave => $valor) {
    $valor = urlencode(stripslashes($valor));
    $req .= "&$clave=$valor";
}
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Host: www.sandbox.paypal.com\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
if (!$fp) {//error de conexi贸n
    $respuesta = "error";
    $texto.="********************************\n";
    $texto.="*********ERROR CONEXI脫N********\n";
    $texto.="********************************\n";
} else {
    fputs($fp, $header . $req);
    while (!feof($fp)) {
        $res = fgets($fp, 1024);
        if (strcmp($res, "VERIFIED") == 0) { //OK
            $respuesta = "ok";
            $texto.="**********************************\n";
            $texto.="*********COMPRA VERIFICADA********\n";
            $texto.="********************************\n";
        } else if (strcmp($res, "INVALID") == 0) { //ERROR
            $respuesta = "no validado";
            $texto.="**********************************\n";
            $texto.="*********COMPRA INVALIDADA********\n";
            $texto.="********************************\n";
        }
    }

    fclose($fp);
}
file_put_contents("log.txt", $texto, FILE_APPEND);
if ($respuesta == "ok") {
    if ($payment_status == "Completed" || $payment_status == "Created" || $payment_status == "Reversed" || $payment_status == "Processed") {
        $verifica = 'verificado';
        $pago = "si";
    } else if ($payment_status == "Pending") {
        $verifica = 'verificado';
        $pago = 'duda';
    } else {
        $verifica = 'verificado';
        $pago = 'no';
    }
} else if ($respuesta == "error") {
    $verifica = 'con error';
    $pago = 'duda';
} else {
    $verifica = 'no verificado';
    $pago = 'duda';
}


    $modeloventa = new ModeloVenta($bd);
    $venta = $modeloventa->get((int) $item_name);
    $venta->setPago($pago);
    $rventa = $modeloventa->edit($venta);
 if ($rventa != 1) {
    $verifica = 'id no válida';
    $pago = 'duda';
}

$paypal = new Paypal(null, (int) $item_name, $verifica);
$modelopay = new ModeloPaypal($bd);
$r = $modelopay->add($paypal);
?>

