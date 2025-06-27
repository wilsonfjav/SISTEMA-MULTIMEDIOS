<?php
class ServicioExtraH {
    public $idServicio;
    public $nombre;
    public $descripcion;

    public function __construct($idServicio = null, $nombre = null, $descripcion = null) {
        $this->idServicio = $idServicio;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }
}


?>