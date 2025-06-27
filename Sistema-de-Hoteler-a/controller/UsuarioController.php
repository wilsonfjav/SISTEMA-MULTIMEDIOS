<?php
// === UsuarioController.php ===
require_once __DIR__.'/../accessData/UsuarioDAO.php';
require_once __DIR__.'/../model/UsuarioH.php';

class UsuarioController {

    private $dao;

    public function __construct() {
        $this->dao = new UsuarioDAO();
    }

    public function obtenerDatos() {
        return $this->dao->obtenerDatos();
    }

    public function obtenerPorId($id) {
        return $this->dao->obtenerPorId($id);
    }

    public function insertar(UsuarioH $objeto) {
        return $this->dao->insertar($objeto);
    }

    public function modificar(UsuarioH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }
}

// Bloque de prueba desde formulario HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Comentario: este bloque permite insertar datos desde un formulario web
    $idUsuario = $_POST['idUsuario'];
    $nombreUsuario = $_POST['nombreUsuario'];
    $claveHash = $_POST['claveHash'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];

    $objeto = new UsuarioH($idUsuario, $nombreUsuario, $claveHash, $rol, $estado);
    $controlador = new UsuarioController();
    $controlador->insertar($objeto);
    exit();
}
?>
