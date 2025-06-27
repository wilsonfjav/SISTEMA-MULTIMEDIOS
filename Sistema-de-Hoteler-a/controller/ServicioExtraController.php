<?php
// === ServicioExtraController.php ===
require_once __DIR__.'/../accessData/ServicioExtraDAO.php';
require_once __DIR__.'/../model/ServicioExtraH.php';

class ServicioExtraController {

    private $dao;

    public function __construct() {
        $this->dao = new ServicioExtraDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar(ServicioExtraH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(ServicioExtraH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

// Este bloque permite hacer pruebas desde formulario HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comentario: prueba de insercion desde formulario
    $idServicio = $_POST['idServicio'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    $objeto = new ServicioExtraH($idServicio, $nombre, $descripcion);
    $controlador = new ServicioExtraController();
    $controlador->insertar($objeto);
    exit();
}
?>
