<?php

require_once __DIR__.'/../accessData/PaqueteDAO.php';
require_once __DIR__.'/../model/PaqueteH.php';

class PaqueteController {

    private $dao;

    public function __construct() {
        $this->dao = new PaqueteDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar(PaqueteH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(PaqueteH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

// BLOQUE DE PRUEBA PARA INSERTAR UN PAQUETE DESDE FORMULARIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtener los datos desde el formulario HTML
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Crear el objeto
    $paquete = new PaqueteH(null, $nombre, $descripcion, $precio);

    // Insertar usando el controlador
    $controlador = new PaqueteController();
    $controlador->insertar($paquete);

    // Redireccionar si se desea (ejemplo para interfaz visual)
    // header("Location: ../view/Paquete");
    exit();
}
?>
