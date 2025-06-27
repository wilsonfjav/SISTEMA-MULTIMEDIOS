<?php
require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/PagoH.php';

class PagoDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los pagos
    public function obtenerDatos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM pagoh");
            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new PagoH(
                    $row['idPago'],
                    $row['idReservacion'],
                    $row['monto'],
                    $row['metodoPago'],
                    $row['fechaPago']
                );
            }

            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }

    // Obtener un pago por su ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.pagoh WHERE idPago = ?");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new PagoH(
                    $row['idPago'],
                    $row['idReservacion'],
                    $row['monto'],
                    $row['metodoPago'],
                    $row['fechaPago']
                );
            }

            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Insertar nuevo pago
    public function insertar(PagoH $objeto) {
        try {
            $sql = "INSERT INTO u484426513_ms225.pagoh(idReservacion, monto, metodoPago, fechaPago) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->idReservacion,
                $objeto->monto,
                $objeto->metodoPago,
                $objeto->fechaPago
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Eliminar pago por ID
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM u484426513_ms225.pagoh WHERE idPago = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Modificar pago existente
    public function modificar(PagoH $objeto) {
        try {
            $sql = "UPDATE u484426513_ms225.pagoh 
                    SET idReservacion = ?, monto = ?, metodoPago = ?, fechaPago = ?
                    WHERE idPago = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->idReservacion,
                $objeto->monto,
                $objeto->metodoPago,
                $objeto->fechaPago,
                $objeto->idPago
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
