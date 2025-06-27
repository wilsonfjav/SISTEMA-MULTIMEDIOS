<?php
require_once __DIR__.'/../misc/Conexion.php';
require_once __DIR__. '/../model/PaqueteH.php';

class PaqueteDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Obtener todos los paquetes
    public function obtenerDatos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM paqueteh");
            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new PaqueteH(
                    $row['idPaquete'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['precio']
                );
            }

            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }

    // Obtener un paquete por su ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.paqueteh WHERE idPaquete = ?");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new PaqueteH(
                    $row['idPaquete'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['precio']
                );
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Insertar nuevo paquete
    public function insertar(PaqueteH $objeto) {
        try {
            $sql = "INSERT INTO u484426513_ms225.paqueteh(nombre, descripcion, precio) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->nombre,
                $objeto->descripcion,
                $objeto->precio
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Eliminar paquete por ID
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM u484426513_ms225.paqueteh WHERE idPaquete = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Modificar paquete existente
    public function modificar(PaqueteH $objeto) {
        try {
            $sql = "UPDATE u484426513_ms225.paqueteh 
                    SET nombre = ?, descripcion = ?, precio = ?
                    WHERE idPaquete = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->nombre,
                $objeto->descripcion,
                $objeto->precio,
                $objeto->idPaquete
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
