<?php

require_once __DIR__.'/../accessData/ClientesDAO.php';
require_once __DIR__.'/../model/ClienteH.php';
//require_once _DIR_.'/../accessData/ClientesDAO.php';
 // requiere one dir debe cambiarse. se supone

class ClienteController{


    private $dao;

    public function __construct(){
        $this->dao = new ClientesDAO();
    }

    public function obtenerDatos(){
        return $this->dao->obtenerDatos();
    }


    public function obtenerPorId($id){
        return $this->dao->obtenerPorId($id);
    }


    public function insertar(ClienteH $objeto){
        return $this->dao->insertar($objeto);
    }

    
    public function modificar(ClienteH $objeto) {
        return $this->dao->modificar($objeto);
    }

    public function eliminar($id) {
        return $this->dao->eliminar($id);
    }

}

// MANEJO PRUEBA 
if ( $_SERVER['REQUEST_METHOD'] == 'POST'){


    $idCliente = $_POST['idCliente'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    $objeto = new ClienteH(null, $idCliente, $nombre, $correo);

    $controlador = new ClienteController();
    $controlador->insertar($objeto);

    //header("Location: ../view/Clientes"); ssolo para viw ddel programa.
    // esto debe cambiarse tambien?
    exit();

}



?>