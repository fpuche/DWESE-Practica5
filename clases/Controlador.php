<?php

function autoload($clase) {
    require $clase . '.php';
}

spl_autoload_register('autoload');

class Controlador {

    function viewCart() {
        $pagina = 0;
        if (Leer::get("pagina") != null) {
            $pagina = Leer::get("pagina");
        }
        $bd = new BaseDatos();
        $modelo = new ModeloProducto($bd);
//        $productos = $modelo->getList();
        $productos = $modelo->getList($pagina);
        $paginas = $modelo->getNumeroPaginas();
        $total = $modelo->count();
        $enlaces = Paginacion::getEnlacesPaginacion($pagina, $total[0], 5);
        $filas = "";
        session_start();

        $precioTotal = 0;
        $iva = 21;
        if (isset($_SESSION["__cesta"])) {
            $cesta = $_SESSION["__cesta"];
            $precio = 0;
            foreach ($cesta as $key => $linea) {
                $precio = $precio + ($linea->getCantidad() * $modelo->get($linea->getIdProducto())->getPrecioProducto());              
            }
            $precioTotal = $precioTotal + $precio;
        }


        if (isset($_SESSION["__cesta"])) {
            $cesta = $_SESSION["__cesta"];

            foreach ($cesta as $key => $linea) {
                $datos = array(
                    "foto" => $modelo->get($linea->getIdProducto())->getFoto(),
                    "nombre" => $modelo->get($linea->getIdProducto())->getNombreProducto(),
                    "descripcion" => $modelo->get($linea->getIdProducto())->getDescripcionProducto(),
                    "precio" => $modelo->get($linea->getIdProducto())->getPrecioProducto(),
                    "id" => $modelo->get($linea->getIdProducto())->getId(),
                    "cantidad" => $linea->getCantidad(),
                    "id" => $modelo->get($linea->getIdProducto())->getId(),
                    "id" => $modelo->get($linea->getIdProducto())->getId()
                );
                $v = new Vista("plantillaCarroDetalle", $datos);
                $filas.= $v->renderData();
            }
        }
        $datos = array(
            "datos" => $filas,
            "subtotal" => $precioTotal - ($precioTotal * ($iva / 100)),
            "iva" => $iva,
            "total" => $precioTotal
        );
        $v = new Vista("plantillaCarro", $datos);
        $v->render();
        exit();
    }

}
