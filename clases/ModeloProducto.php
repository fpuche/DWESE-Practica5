<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModeloProducto
 *
 * @author Fernando
 */
class ModeloProducto {

    private $bd;
    private $tabla = "producto";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Añade un objeto a la tabla 
     * @access public
     * @return int
     */
    /* $id, $nombreProducto, $descripcionProducto, $precioProducto, $ivaProducto; */
    function add(Producto $objeto) {
        $sql = "insert into $this->tabla values(null, :nombre, :descripcion, :precio, :foto);";
        $parametros["nombreProducto"] = $objeto->getNombreProducto();
        $parametros["descripcionProducto"] = $objeto->getDescripcionProducto();
        $parametros["precioProducto"] = $objeto->getPrecioProducto();
        $parametros["ivaProducto"] = $objeto->getIvaProducto();
        $parametros["foto"] = $objeto->getFoto();
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
    function delete(Producto $objeto) {
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
        return $this->delete(new Producto($id));
    }

    /**
     * Edita elementos de la tabla
     * @access public
     * @return int
     */
    function edit(Producto $objeto) {
        $sql = "update $this->tabla  set nombreProducto = :nombreProducto, descripcionProducto = :descripcionProducto, precioProducto = :precioProducto, ivaProducto = :ivaProducto, foto = :foto where id = :id";
        $parametros["nombreProducto"] = $objeto->getNombreProducto();
        $parametros["descripcionProducto"] = $objeto->getDescripcionProducto();
        $parametros["precioProducto"] = $objeto->getPrecioProducto();
        $parametros["ivaProducto"] = $objeto->getIvaProducto();
        $parametros["foto"] = $objeto->getFoto();
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
    function editPK(Producto $objetoOriginal, Producto $objetoNuevo) {
        $sql = "update $this->tabla  set nombreProducto = :nombreProducto, descripcionProducto = :descripcionProducto, precioProducto = :precioProducto, ivaProducto = :ivaProducto, foto = :foto where id = :idpk";
        $parametros["nombreProducto"] = $objetoNuevo->getNombreProducto();
        $parametros["descripcionProducto"] = $objetoNuevo->getDescripcionProducto();
        $parametros["precioProducto"] = $objetoNuevo->getPrecioProducto();
        $parametros["ivaProducto"] = $objetoNuevo->getIvaProducto();
        $parametros["foto"] = $objetoNuevo->getFoto();
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
            $producto = new Producto();
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
                $producto = new Producto();
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
            $objeto = new Producto();
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
    /* $id, $nombreProducto, $descripcionProducto, $precioProducto, $ivaProducto; */
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
            $select .="<option $selected value='" . $objeto->getId() . "'>" . $objeto->getNombreProducto() . ", " . $objeto->getDescripcionProducto() . ", " . $objeto->getPrecioProducto() . ", " . $objeto->getIvaProducto() . ", " . $objeto->getFoto() . "</option>";
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
            $objeto = new Producto();
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
