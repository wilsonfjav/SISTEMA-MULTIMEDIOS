<?php

require_once __DIR__ . '/../accessData/DetalleReservacionDAO.php';
require_once __DIR__ . '/../model/DetalleReservacionH.php';

class DetalleReservacionController {

    private $dao;

    public function __construct() {
        $this->dao = new DetalleReservacionDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar(DetalleReservacionH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(DetalleReservacionH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

// Este bloque es solo para pruebas rápidas directas (formulario o Postman con POST).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idReservacion = $_POST['idReservacion'];
    $idHabitacion  = $_POST['idHabitacion'];

    $objeto = new DetalleReservacionH(null, $idReservacion, $idHabitacion);

    $controlador = new DetalleReservacionController();
    $controlador->insertar($objeto);

    exit();
}
?>
