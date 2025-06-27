<?php
class ConsumoH {
    public $idConsumo;
    public $idReservacion;
    public $idServicio;
    public $cantidad;
    public $fecha;

    public function __construct($idConsumo = null , $idReservacion = null, $idServicio = null, $cantidad = null, $fecha = null) {
        $this->idConsumo = $idConsumo;
        $this->idReservacion = $idReservacion;
        $this->idServicio = $idServicio;
        $this->cantidad = $cantidad;
        $this->fecha = $fecha;
    }
}

?>