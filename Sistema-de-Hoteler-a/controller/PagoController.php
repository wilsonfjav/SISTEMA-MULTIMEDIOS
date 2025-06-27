<?php

require_once __DIR__ . '/../accessData/PagoDAO.php';
require_once __DIR__ . '/../model/PagoH.php';

class PagoController {

    private $dao;

    public function __construct() {
        $this->dao = new PagoDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar(PagoH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(PagoH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

// Manejo para pruebas con formulario POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Aqui se procesa el envio desde formulario para insertar un nuevo pago

    $idReservacion = $_POST['idReservacion'];
    $monto = $_POST['monto'];
    $metodoPago = $_POST['metodoPago'];
    $fechaPago = $_POST['fechaPago'];

    $objeto = new PagoH(null, $idReservacion, $monto, $metodoPago, $fechaPago);
    $controlador = new PagoController();
    $controlador->insertar($objeto);

    // Aqui se puede redirigir a una vista luego de insertar si se desea
    exit();
}

?>
