<?php
class HabitacionH {
    public $idHabitacion;
    public $numero;
    public $idTipo;
    public $precio;

    public function __construct($idHabitacion = null, $numero = null, $idTipo = null, $precio = null) {
        $this->idHabitacion = $idHabitacion;
        $this->numero = $numero;
        $this->idTipo = $idTipo;
        $this->precio = $precio;
    }
}

?>