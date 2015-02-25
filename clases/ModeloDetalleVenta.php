<?php

class ModeloDetalleVenta {
  private $bd;
    private $tabla = "detalleVenta";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Añade un objeto a la tabla 
     * @access public
     * @return int
     */
    /* $id, $idVenta, $idProducto, $cantidad, $precioVenta, $ivaVenta; */
    function add(DetalleVenta $objeto) {
        $sql = "insert into $this->tabla values(null, :idVenta, :idProducto, :cantidad, :precioVenta, :ivaVenta);";
        $parametros["idVenta"] = $objeto->getIdVenta();
        $parametros["idProducto"] = $objeto->getIdProducto();
        $parametros["cantidad"] = $objeto->getCantidad();
        $parametros["precioVenta"] = $objeto->getPrecioVenta();
        $parametros["ivaVenta"] = $objeto->getIvaVenta();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico();
    }

    function getTabla() {
        return $this->tabla;
    }

    /**
     * Devuelve el total de páginas
     * @access public
     * @return int
     */
    function getNumeroPaginas($rpp = Configuracion::RPP) {
        $lista = $this->count();
        return (ceil($lista[0] / $rpp) - 1);
    }

    /**
     * Borra elementos de la tabla
     * @access public
     * @return int
     */
    function delete(DetalleVenta $objeto) {
        $sql = "delete from $this->tabla where id = :id;";
        $parametros["id"] = $objeto->getId();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Borra elementos de la tabla por su id
     * @access public
     * @return int
     */
    function deletePorId($id) {
        return $this->delete(new DetalleVenta($id));
    }

    /**
     * Edita elementos de la tabla
     * @access public
     * @return int
     */
    function edit(DetalleVenta $objeto) {
        $sql = "update $this->tabla  set idVenta = :idVenta, idProducto = :idProducto, cantidad = :cantidad, precioVenta = :precioVenta, ivaVenta = :ivaVenta where id = :id";
        $parametros["idVenta"] = $objeto->getIdVenta();
        $parametros["idProducto"] = $objeto->getIdProducto();
        $parametros["cantidad"] = $objeto->getCantidad();
        $parametros["precioVenta"] = $objeto->getPrecioVenta();
        $parametros["ivaVenta"] = $objeto->getIvaVenta();
        $parametros["id"] = $objeto->getId();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Edita elementos de la tabla plato por su id
     * @access public
     * @return int
     */
    
        function editPK(DetalleVenta $objetoOriginal, DetalleVenta $objetoNuevo) {
         $sql = "update $this->tabla  set idVenta = :idVenta, idProducto = :idProducto, cantidad = :cantidad, precioVenta = :precioVenta, ivaVenta = :ivaVenta where id = :idpk";
       $parametros["idVenta"] = $objetoNuevo->getIdVenta();
        $parametros["idProducto"] = $objetoNuevo->getIdProducto();
        $parametros["cantidad"] = $objetoNuevo->getCantidad();
        $parametros["precioVenta"] = $objetoNuevo->getPrecioVenta();
        $parametros["ivaVenta"] = $objetoNuevo->getIvaVenta();
        $parametros["id"] = $objetoNuevo->getId();
        $parametros["idpk"] = $objetoOriginal->getId();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Retorna un objeto plato de la base de datos restaurante por su id
     * @access public
     * @return una casa o null
     */
    function get($id) {
        $sql = "select * from $this->tabla where id = :id";
        $parametros["id"] = $id;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $producto = new DetalleVenta();
            $producto->set($this->bd->getFila());
            return $producto;
        }
        return null;
    }

    /**
     * El número de platos que coinciden con una condición
     * @access public
     * @return int
     */
    function count($condicion = "1=1", $parametros = array()) {
        $sql = "select count(*) from $this->tabla where $condicion";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            //return $numero = $this->bd->getFila(0);
            $aux = $this->bd->getFila();
            return $aux[0];
        } else {
            return -1;
        }
    }

    /**
     * Crea la lista de platos según requisitos de paginación
     * @access public
     * @return array o null
     */
    function getList($pagina = 0, $rpp = 5, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $list = array();
        $principio = $pagina * $rpp; // si empezaramos por 1 en vez de por cero sería $pagina -1 * $rpp
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $principio, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $producto = new DetalleVenta();
                $producto->set($fila);
                $list[] = $producto;
            }
        } else {
            return null;
        }
        return $list;
    }

    function getListPagina($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from "
                . $this->tabla .
                " where $condicion order by $orderby limit $pos, $rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        $respuesta = array();
        while ($fila = $this->bd->getFila()) {
            $objeto = new DetalleVenta();
            $objeto->set($fila);
            $respuesta[] = $objeto;
        }
        return $respuesta;
    }

    /**
     * Crea selects html con los valores de de la tabla plato
     * @access public
     * @return string
     */
       /* $id, $idVenta, $idProducto, $cantidad, $precioVenta, $ivaVenta; */
    function selectHtml($id, $name, $condicion, $parametros, $orderby = 1, $valorSeleccionado = "", $blanco = true, $textoBlanco = "&nbsp;") {
        $select = "<select name='$name' id='$id'>";
        $select .="</select>";
        if ($blanco) {
            $select .="<option value=''>$textoBlanco</option>";
        }
        $lista = $this->getList($condicion, $parametros, $orderby);
        foreach ($lista as $objeto) {
            $selected = "";
            if ($objeto->getId() == $valorSeleccionado) {
                $selected = "selected";
            }
            $select .="<option $selected value='" . $objeto->getId() . "'>" . $objeto->getIdVenta() . ", " . $objeto->getIdProducto() . ", " . $objeto->getCantidad() . ", " . $objeto->getPrecioVenta() .", " . $objeto->getIvaVenta() . "</option>";
        }
        $select .= "</select>";
        return $select;
    }

    /**
     * crea un conjunto de objetos plato a partir de unas condiciones
     * @access public
     * @return cadena con los objetos usuario
     */
    function getListJSON($pagina = 0, $rpp = 5, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $pos = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $pos, $rpp";
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new DetalleVenta();
            $objeto->set($fila);
            $r .=$objeto->getJSON() . ",";
        }

        $r = substr($r, 0, -1) . "]";
        return $r;
    }

    function getJSON($id) {
        return $this->get($id)->getJSON();
    }
}

?>
