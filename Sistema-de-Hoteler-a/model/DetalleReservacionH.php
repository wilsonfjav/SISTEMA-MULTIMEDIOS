<?php
class DetalleReservacionH {
    public $idDetalle;
    public $idReservacion;
    public $idHabitacion;

    public function __construct($idDetalle = null, $idReservacion = null, $idHabitacion = null) {
        $this->idDetalle = $idDetalle;
        $this->idReservacion = $idReservacion;
        $this->idHabitacion = $idHabitacion;
    }
}

?>