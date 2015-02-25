<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Producto
 *
 * @author Fernando
 */
class Producto {


    private $id, $nombreProducto, $descripcionProducto, $precioProducto, $ivaProducto, $foto;
    
    function __construct($id=null, $nombreProducto="", $descripcionProducto="", $precioProducto=0, $ivaProducto=0, $foto = "") {
        $this->id = $id;
        $this->nombreProducto = $nombreProducto;
        $this->descripcionProducto = $descripcionProducto;
        $this->precioProducto = $precioProducto;
        $this->ivaProducto = $ivaProducto;
        $this->foto = $foto;
    }


    /**
     * Asigna a cada variable su valor contenido en un array
     * @access public
     * @return asigna valor a las variables
     */
    function set($datos, $inicio = 0) {
        $this->id = $datos[0 + $inicio];
        $this->nombreProducto = $datos[1 + $inicio];
        $this->descripcionProducto = $datos[2 + $inicio];
        $this->precioProducto = $datos[3 + $inicio];
        $this->ivaProducto = $datos[4 + $inicio];
        $this->foto = $datos[5 + $inicio];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombreProducto() {
        return $this->nombreProducto;
    }

    public function setNombreProducto($nombreProducto) {
        $this->nombreProducto = $nombreProducto;
    }

    public function getDescripcionProducto() {
        return $this->descripcionProducto;
    }

    public function setDescripcionProducto($descripcionProducto) {
        $this->descripcionProducto = $descripcionProducto;
    }

    public function getPrecioProducto() {
        return $this->precioProducto;
    }

    public function setPrecioProducto($precioProducto) {
        $this->precioProducto = $precioProducto;
    }

    public function getIvaProducto() {
        return $this->ivaProducto;
    }

    public function setIvaProducto($ivaProducto) {
        $this->ivaProducto = $ivaProducto;
    }
    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }
      
    public function getJSON() {
        $prop = get_object_vars($this);
        $resp = '{ ';
        foreach ($prop as $key => $value) {
            $resp.='"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';
        }
        $resp = substr($resp, 0, -1) . "}";
        return $resp;
    }

}


?>
