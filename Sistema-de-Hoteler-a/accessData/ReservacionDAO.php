<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/ReservacionH.php';

class ReservacionDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Metodo para obtener todas las reservaciones
    public function obtenerDatos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM reservacionh");
            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new ReservacionH(
                    $row['idReservacion'],
                    $row['idCliente'],
                    $row['fechaInicio'],
                    $row['fechaFin'],
                    $row['estado']
                );
            }

            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }

    // Metodo para obtener una reservacion por su ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.reservacionh WHERE idReservacion = ?");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new ReservacionH(
                    $row['idReservacion'],
                    $row['idCliente'],
                    $row['fechaInicio'],
                    $row['fechaFin'],
                    $row['estado']
                );
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Metodo para insertar una nueva reservacion
    public function insertar(ReservacionH $objeto) {
        try {
            $sql = "INSERT INTO u484426513_ms225.reservacionh(idCliente, fechaInicio, fechaFin, estado) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->idCliente,
                $objeto->fechaInicio,
                $objeto->fechaFin,
                $objeto->estado
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Metodo para eliminar una reservacion por su ID
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM u484426513_ms225.reservacionh WHERE idReservacion = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Metodo para modificar una reservacion existente
    public function modificar(ReservacionH $objeto) {
        try {
            $sql = "UPDATE u484426513_ms225.reservacionh 
                    SET idCliente = ?, fechaInicio = ?, fechaFin = ?, estado = ?
                    WHERE idReservacion = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->idCliente,
                $objeto->fechaInicio,
                $objeto->fechaFin,
                $objeto->estado,
                $objeto->idReservacion
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
