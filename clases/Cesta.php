<?php

class Cesta implements Iterator {

    private $arraycesta; //array
    private $posicion = 0;

    function __construct() {
        $this->arraycesta = array();
       // $bd= new BaseDatos();
    }

    function add(DetalleVenta $detalle) {
        $id = $detalle->getIdProducto();

        if (isset($this->arraycesta[$id])) {
            $detalle = $this->arraycesta[$id];
            $detalle->setCantidad($detalle->getCantidad() + 1);
        } else {
            $this->arraycesta[$id] = $detalle;
        }
    }

    function del($id) {
        unset($this->arraycesta[$id]);
    }

    function sub($id) {
        if (isset($this->arraycesta[$id])) {
            $lineacesta = $this->arraycesta[$id];
            $lineacesta->setCantidad($lineacesta->getCantidad() - 1);
            if ($lineacesta->getCantidad() < 1) {
                $this->del($id);
            }
        }
    }

    public function current() {   // devuelve el valor (objeto) de la clave de esa posición
        $claves = array_keys($this->arraycesta);
        // return $this->arraycesta($claves($this->posicion));
        return $this->arraycesta[$this->key()];
    }

    public function key() {
        $claves = array_keys($this->arraycesta);
        return $claves($this->posicion); //devuelve la clave de la posición
    }

    public function next() { //Incrementa el contador
        $this->posicion++;
    }

    public function rewind() { // vamos a la primera posic´ón
        $this->posicion = 0;
    }

    public function valid() { // dice si en esa clave hay algo o no
        $claves = array_keys($this->arraycesta);
        if (isset($claves[$this->contador]))
            return isset($this->arraycesta[$claves[$this->contador]]);
        return false;
    }
    
   

}
