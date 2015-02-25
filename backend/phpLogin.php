<?php

require '../require/comun.php';
$bd = new BaseDatos();
$login = Leer::post("login");
$clave = Leer::post("password");

$modelo = new ModeloUsuario($bd);
$usuario = $modelo->autentifica($login, $clave);
$usuario = $modelo->login($login, $clave);
if($usuario instanceof Usuario){

    $sesion->setUsuario($usuario);
    $modelo->fechalogin($usuario);
    $bd->closeConexion();
    echo 'entra';
    header("Location:admin.php"); 

} else {
   
    $sesion->cerrar();
    $bd->closeConexion();
    header("Location:../login.php?error=Login o clave incorrectos");
}
