<?php
class UsuarioH{
    public $idUsuario;
    public $nombreUsuario;
    public $claveHash;
    public $rol;
    public $estado;

    public function __construct($idUsuario = null, $nombreUsuario = null, $claveHash = null, $rol = 'admin', $estado = 'activo') {
        $this->idUsuario = $idUsuario;
        $this->nombreUsuario = $nombreUsuario;
        $this->claveHash = $claveHash;
        $this->rol = $rol;
        $this->estado = $estado;
    }
}

?>

