<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Paypal
 *
 * @author Fernando
 */
class Paypal {
private $id, $itemname, $verifica;


function __construct($id= null, $itemname="", $verifica="no verificado") {
    $this->id = $id;
    $this->itemname = $itemname;
    $this->verifica = $verifica;
}

    /**
     * Asigna a cada variable su valor contenido en un array
     * @access public
     * @return asigna valor a las variables
     */
    function set($datos, $inicio = 0) {
        $this->id = $datos[0 + $inicio];
        $this->itemname = $datos[1 + $inicio];
        $this->verifica = $datos[2 + $inicio];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getItemname() {
        return $this->itemname;
    }

    public function setItemname($itemname) {
        $this->itemname = $itemname;
    }

    public function getVerifica() {
        return $this->verifica;
    }

    public function setVerifica($verifica) {
        $this->verifica = $verifica;
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
