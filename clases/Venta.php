<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Venta
 *
 * @author Fernando
 */
class Venta {
private $id, $fecha, $hora, $pago, $nombreUsuario, $dirUsuario, $precioTotal;


function __construct($id=null, $fecha=null, $hora=null, $pago='no', $nombreUsuario= null, $dirUsuario=null, $precioTotal=0) {
    $this->id = $id;
    $this->fecha = $fecha;
    $this->hora = $hora;
    $this->pago = $pago;
    $this->nombreUsuario = $nombreUsuario;
    $this->dirUsuario = $dirUsuario;
    $this->precioTotal = $precioTotal;
}

    /**
     * Asigna a cada variable su valor contenido en un array
     * @access public
     * @return asigna valor a las variables
     */
    function set($datos, $inicio = 0) {
        $this->id = $datos[0 + $inicio];
        $this->fecha = $datos[1 + $inicio];
        $this->hora = $datos[2 + $inicio];
        $this->pago = $datos[3 + $inicio];
        $this->nombreUsuario = $datos[4 + $inicio];
        $this->dirUsuario = $datos[5 + $inicio];
        $this->precioTotal= $datos[6 + $inicio];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function getPago() {
        return $this->pago;
    }

    public function setPago($pago) {
        $this->pago = $pago;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function getDirUsuario() {
        return $this->dirUsuario;
    }

    public function setDirUsuario($dirUsuario) {
        $this->dirUsuario = $dirUsuario;
    }

    public function getPrecioTotal() {
        return $this->precioTotal;
    }

    public function setPrecioTotal($precioTotal) {
        $this->precioTotal = $precioTotal;
    }

                /**
     * Presenta al objeto/s en modo JSON
     * @access public
     * @return cadena
     */
    public function getJSON() {
        $prop = get_object_vars($this);
        $resp = "{ ";
        foreach ($prop as $key => $value) {
            $resp.='"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';
        }
        $resp = substr($resp, 0, -1) . "}";
        return $resp;
    }

}

?>
