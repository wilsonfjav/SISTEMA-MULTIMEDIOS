<?php
require_once __DIR__ .'/../misc/Conexion.php';
require_once __DIR__ .'/../model/ServicioExtraH.php';

class ServicioExtraDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Metodo para obtener todos los servicios extra
    public function obtenerDatos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM servicioExtrah");
            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new ServicioExtraH(
                    $row['idServicio'],
                    $row['nombre'],
                    $row['descripcion']
                );
            }

            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }

    // Metodo para obtener un servicio extra por ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.servicioExtrah WHERE idServicio = ?");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new ServicioExtraH(
                    $row['idServicio'],
                    $row['nombre'],
                    $row['descripcion']
                );
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Metodo para insertar un nuevo servicio extra
    public function insertar(ServicioExtraH $objeto) {
        try {
            $sql = "INSERT INTO u484426513_ms225.servicioExtrah(nombre, descripcion) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->nombre,
                $objeto->descripcion
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Metodo para eliminar un servicio extra por ID
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM u484426513_ms225.servicioExtrah WHERE idServicio = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Metodo para modificar un servicio extra existente
    public function modificar(ServicioExtraH $objeto) {
        try {
            $sql = "UPDATE u484426513_ms225.servicioExtrah 
                    SET nombre = ?, descripcion = ?
                    WHERE idServicio = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->nombre,
                $objeto->descripcion,
                $objeto->idServicio
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>
