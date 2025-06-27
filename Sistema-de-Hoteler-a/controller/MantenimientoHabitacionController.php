<?php

require_once __DIR__ . '/../accessData/MantenimientoHabitacionDAO.php';
require_once __DIR__ . '/../model/MantenimientoHabitacionH.php';

class MantenimientoHabitacionController {

    private $dao;

    public function __construct() {
        $this->dao = new MantenimientoHabitacionDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar(MantenimientoHabitacionH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(MantenimientoHabitacionH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

// Este bloque se puede usar para pruebas directas desde un formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aqui se puede recibir la informacion desde un formulario HTML
    $idMantenimiento = $_POST['idMantenimiento'];
    $idHabitacion = $_POST['idHabitacion'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];

    $objeto = new MantenimientoHabitacionH($idMantenimiento, $idHabitacion, $descripcion, $fecha);

    $controlador = new MantenimientoHabitacionController();
    $controlador->insertar($objeto);

    // Se puede redireccionar a otra vista si se desea
    // header("Location: ../view/Mantenimientos");
    exit();
}
?>
