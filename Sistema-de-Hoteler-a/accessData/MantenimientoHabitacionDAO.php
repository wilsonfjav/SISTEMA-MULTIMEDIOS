<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ .'/../model/MantenimientoHabitacionH.php';

class MantenimientoHabitacionDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los registros
    public function obtenerDatos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM mantenimientoHabitacionh");
            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new MantenimientoHabitacionH(
                    $row['idMantenimiento'],
                    $row['idHabitacion'],
                    $row['descripcion'],
                    $row['fecha']
                );
            }

            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }

    // Obtener un registro por ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.mantenimientoHabitacionh WHERE idMantenimiento = ?");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new MantenimientoHabitacionH(
                    $row['idMantenimiento'],
                    $row['idHabitacion'],
                    $row['descripcion'],
                    $row['fecha']
                );
            }

            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Insertar un nuevo registro
    public function insertar(MantenimientoHabitacionH $objeto) {
        try {
            $sql = "INSERT INTO u484426513_ms225.mantenimientoHabitacionh(idHabitacion, descripcion, fecha) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->idHabitacion,
                $objeto->descripcion,
                $objeto->fecha
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Eliminar un registro por ID
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM u484426513_ms225.mantenimientoHabitacionh WHERE idMantenimiento = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Modificar un registro existente
    public function modificar(MantenimientoHabitacionH $objeto) {
        try {
            $sql = "UPDATE u484426513_ms225.mantenimientoHabitacionh 
                    SET idHabitacion = ?, descripcion = ?, fecha = ?
                    WHERE idMantenimiento = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->idHabitacion,
                $objeto->descripcion,
                $objeto->fecha,
                $objeto->idMantenimiento
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>
