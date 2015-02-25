<?php

class DetalleVenta {
 private $id, $idVenta, $idProducto, $cantidad, $precioVenta, $ivaVenta, $total;
// , $producto;
 
 
 function __construct($id=null, $idVenta= null, $idProducto = null, $cantidad = 0, $precioVenta = 0, $ivaVenta = 0) {
     $this->id = $id;
     $this->idVenta = $idVenta;
     $this->idProducto = $idProducto;
     $this->cantidad = $cantidad;
     $this->precioVenta = $precioVenta;
     $this->ivaVenta = $ivaVenta;
//     $bd = new BaseDatos();
//     $modelo = new ModeloProducto($bd);
//     $this->producto = $modelo->get($id);
 }
   /**
     * Asigna a cada variable su valor contenido en un array
     * @access public
     * @return asigna valor a las variables
     */
    function set($datos, $inicio = 0) {
        $this->id = $datos[0 + $inicio];
        $this->idVenta = $datos[1 + $inicio];
        $this->idProducto = $datos[2 + $inicio];
        $this->cantidad = $datos[3 + $inicio];
        $this->precioVenta = $datos[4 + $inicio];
        $this->ivaVenta = $datos[5 + $inicio];
    }
//    public function getProducto() {
//        return $this->producto;
//    }
//
//    public function setProducto($producto) {
//        $this->producto = $producto;
//    }

        public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdVenta() {
        return $this->idVenta;
    }

    public function setIdVenta($idVenta) {
        $this->idVenta = $idVenta;
    }

    public function getIdProducto() {
        return $this->idProducto;
    }

    public function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getPrecioVenta() {
        return $this->precioVenta;
    }

    public function setPrecioVenta($precioVenta) {
        $this->precioVenta = $precioVenta;
    }

    public function getIvaVenta() {
        return $this->ivaVenta;
    }

    public function setIvaVenta($ivaVenta) {
        $this->ivaVenta = $ivaVenta;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
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
