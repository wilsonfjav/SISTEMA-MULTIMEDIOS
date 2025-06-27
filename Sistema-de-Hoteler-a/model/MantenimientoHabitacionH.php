<?php
class MantenimientoHabitacionH {
    public $idMantenimiento;
    public $idHabitacion;
    public $descripcion;
    public $fecha;

    public function __construct($idMantenimiento = null, $idHabitacion = null, $descripcion = null, $fecha = null) {
        $this->idMantenimiento = $idMantenimiento;
        $this->idHabitacion = $idHabitacion;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
    }
}

?>