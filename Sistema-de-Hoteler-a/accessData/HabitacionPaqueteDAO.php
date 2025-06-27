<?php

require_once __DIR__ .'/../misc/Conexion.php';
require_once __DIR__ .'/../model/HabitacionPaqueteH.php';

class HabitacionPaqueteDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los registros
    public function obtenerDatos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM habitacionPaqueteh");
            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new HabitacionPaqueteH(
                    $row['idHabitacion'],
                    $row['idPaquete']
                );
            }

            return $result;
        } catch (PDOException $e) {
            return []; // Retorna lista vacia si hay error
        }
    }

    // Obtener un registro por ID doble (clave compuesta)
    public function obtenerPorId($idHabitacion, $idPaquete) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.habitacionPaqueteh WHERE idHabitacion = ? AND idPaquete = ?");
            $stmt->execute([$idHabitacion, $idPaquete]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new HabitacionPaqueteH(
                    $row['idHabitacion'],
                    $row['idPaquete']
                );
            }

            return null; // Si no hay datos
        } catch (PDOException $e) {
            return null;
        }
    }

    // Insertar un nuevo registro
    public function insertar(HabitacionPaqueteH $objeto) {
        try {
            $sql = "INSERT INTO u484426513_ms225.habitacionPaqueteh(idHabitacion, idPaquete) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->idHabitacion,
                $objeto->idPaquete
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Eliminar un registro por clave compuesta
    public function eliminar($idHabitacion, $idPaquete) {
        try {
            $sql = "DELETE FROM u484426513_ms225.habitacionPaqueteh WHERE idHabitacion = ? AND idPaquete = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$idHabitacion, $idPaquete]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Modificar un registro existente usando clave compuesta
    public function modificar(HabitacionPaqueteH $objeto, $idHabitacionAnterior, $idPaqueteAnterior) {
        try {
            $sql = "UPDATE u484426513_ms225.habitacionPaqueteh 
                    SET idHabitacion = ?, idPaquete = ?
                    WHERE idHabitacion = ? AND idPaquete = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->idHabitacion,
                $objeto->idPaquete,
                $idHabitacionAnterior,
                $idPaqueteAnterior
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>
