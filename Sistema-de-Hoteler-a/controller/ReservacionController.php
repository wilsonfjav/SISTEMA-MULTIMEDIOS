<?php
// === ReservacionController.php ===
require_once __DIR__.'/../accessData/ReservacionDAO.php';
require_once __DIR__.'/../model/ReservacionH.php';

class ReservacionController {

    private $dao;

    public function __construct() {
        $this->dao = new ReservacionDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar(ReservacionH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(ReservacionH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

// Manejo de prueba POST desde formulario HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comentario: este bloque permite probar desde formulario web
    $idReservacion = $_POST['idReservacion'];
    $idCliente = $_POST['idCliente'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $estado = $_POST['estado'];

    $objeto = new ReservacionH($idReservacion, $idCliente, $fechaInicio, $fechaFin, $estado);
    $controlador = new ReservacionController();
    $controlador->insertar($objeto);
    exit();
}

?>
