<?php

require_once __DIR__ . '/../accessData/ConsumoDAO.php';
require_once __DIR__ . '/../model/ConsumoH.php';

class ConsumoController {

    private $dao;

    public function __construct() {
        $this->dao = new ConsumoDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar(ConsumoH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(ConsumoH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

// Este bloque es solo para pruebas rápidas directas desde un formulario o Postman con POST.
// En una aplicación bien estructurada, las peticiones HTTP deben manejarse únicamente desde el APIController.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idReservacion = $_POST['idReservacion'];
    $idServicio    = $_POST['idServicio'];
    $cantidad      = $_POST['cantidad'];
    $fecha         = $_POST['fecha'];

    $objeto = new ConsumoH(null, $idReservacion, $idServicio, $cantidad, $fecha);

    $controlador = new ConsumoController();
    $controlador->insertar($objeto);

    exit();
}
?>
