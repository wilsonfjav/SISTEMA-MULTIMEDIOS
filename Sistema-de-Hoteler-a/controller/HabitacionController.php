<?php

require_once __DIR__ . '/../accessData/HabitacionDAO.php';
require_once __DIR__ . '/../model/HabitacionH.php';

class HabitacionController {

    private $dao;

    public function __construct() {
        $this->dao = new HabitacionDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar(HabitacionH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(HabitacionH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

// ⚠️ Prueba con POST (solo para pruebas manuales desde formularios HTML)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero'];
    $idTipo = $_POST['idTipo'];
    $precio = $_POST['precio'];

    $habitacion = new HabitacionH(null, $numero, $idTipo, $precio);
    $controlador = new HabitacionController();
    $controlador->insertar($habitacion);

    // header('Location: ../view/habitaciones.php'); // solo si tienes vista
    exit();
}
