<?php
// === TipoHabitacionController.php ===
require_once __DIR__.'/../accessData/TipoHabitacionDAO.php';
require_once __DIR__.'/../model/TipoHabitacionH.php';

class TipoHabitacionController {

    private $dao;

    public function __construct() {
        $this->dao = new TipoHabitacionDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar(TipoHabitacionH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(TipoHabitacionH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

// Bloque de prueba para insertar desde un formulario HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Este bloque permite insertar datos desde un formulario
    $idTipo = $_POST['idTipo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $objeto = new TipoHabitacionH($idTipo, $nombre, $descripcion);
    $controlador = new TipoHabitacionController();
    $controlador->insertar($objeto);
    exit();
}
?>
