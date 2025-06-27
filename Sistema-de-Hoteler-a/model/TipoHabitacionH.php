<?php
class TipoHabitacionH {
    public $idTipo;
    public $nombre;
    public $descripcion;

    public function __construct($idTipo = null, $nombre = null, $descripcion = null) {
        $this->idTipo = $idTipo;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
    }
}


?>