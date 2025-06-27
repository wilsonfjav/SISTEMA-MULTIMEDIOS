<?php

require_once __DIR__.'/../misc/Conexion.php';
require_once __DIR__.'/../model/ConsumoH.php';

class ConsumoDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    public function obtenerDatos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM consumoh");
            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new ConsumoH(
                    $row['idConsumo'],
                    $row['idReservacion'],
                    $row['idServicio'],
                    $row['cantidad'],
                    $row['fecha']
                );
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Error en obtenerDatos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.consumoh WHERE idConsumo = ?;");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return new ConsumoH(
                $row['idConsumo'],
                $row['idReservacion'],
                $row['idServicio'],
                $row['cantidad'],
                $row['fecha']
            );
        } catch (PDOException $e) {
            error_log("Error en obtenerPorId: " . $e->getMessage());
            return null;
        }
    }

    public function insertar(ConsumoH $objeto) {
        try {
            $sql = "INSERT INTO u484426513_ms225.consumoh(idReservacion, idServicio, cantidad, fecha) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->idReservacion,
                $objeto->idServicio,
                $objeto->cantidad,
                $objeto->fecha
            ]);
        } catch (PDOException $e) {
            error_log("Error en insertar: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar($id) {
        try {
            $sql = "DELETE FROM u484426513_ms225.consumoh WHERE idConsumo = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Error en eliminar: " . $e->getMessage());
            return false;
        }
    }

    public function modificar(ConsumoH $objeto) {
        try {
            $sql = "UPDATE u484426513_ms225.consumoh 
                    SET idReservacion = ?, idServicio = ?, cantidad = ?, fecha = ?
                    WHERE idConsumo = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->idReservacion,
                $objeto->idServicio,
                $objeto->cantidad,
                $objeto->fecha,
                $objeto->idConsumo
            ]);
        } catch (PDOException $e) {
            error_log("Error en modificar: " . $e->getMessage());
            return false;
        }
    }

}

?>
