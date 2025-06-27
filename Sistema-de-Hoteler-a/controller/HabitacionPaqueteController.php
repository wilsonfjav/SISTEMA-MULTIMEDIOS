<?php

require_once __DIR__ . '/../accessData/HabitacionPaqueteDAO.php';
require_once __DIR__ . '/../model/HabitacionPaqueteH.php';

class HabitacionPaqueteController {

    private $dao;

    public function __construct() {
        $this->dao = new HabitacionPaqueteDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($idHabitacion, $idPaquete) {
        return $this->dao->obtenerPorId($idHabitacion, $idPaquete);
    }

    public function insertar(HabitacionPaqueteH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(HabitacionPaqueteH $objeto, $idHabitacionAnterior, $idPaqueteAnterior) {
        return $this->dao->modificar($objeto, $idHabitacionAnterior, $idPaqueteAnterior);
    }

    public function eliminar($idHabitacion, $idPaquete) {
        return $this->dao->eliminar($idHabitacion, $idPaquete);
    }
}

// IF de prueba para insertar desde formulario HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Este bloque es solo para pruebas sin frontend: permite insertar desde un formulario
    $idHabitacion = $_POST['idHabitacion'];
    $idPaquete = $_POST['idPaquete'];

    $objeto = new HabitacionPaqueteH($idHabitacion, $idPaquete);
    $controlador = new HabitacionPaqueteController();
    $controlador->insertar($objeto);

    // Redireccion o mensaje de exito si se usa en una vista
    exit();
}
?>
