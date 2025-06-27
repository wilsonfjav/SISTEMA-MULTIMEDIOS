<?php

require_once __DIR__ .'/../misc/Conexion.php';
require_once __DIR__ . '/../model/TipoHabitacionH.php';

class TipoHabitacionDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Metodo para obtener todos los registros de tipo habitacion
    public function obtenerDatos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM tipoHabitacionh");

            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new TipoHabitacionH(
                    $row['idTipo'],
                    $row['nombre'],
                    $row['descripcion']
                );
            }

            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }

    // Metodo para obtener un tipo de habitacion por su ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.tipoHabitacionh WHERE idTipo = ?");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new TipoHabitacionH(
                    $row['idTipo'],
                    $row['nombre'],
                    $row['descripcion']
                );
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Metodo para insertar un nuevo tipo de habitacion
    public function insertar(TipoHabitacionH $objeto) {
        try {
            $sql = "INSERT INTO u484426513_ms225.tipoHabitacionh(nombre, descripcion) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->nombre,
                $objeto->descripcion
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Metodo para eliminar un tipo de habitacion por ID
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM u484426513_ms225.tipoHabitacionh WHERE idTipo = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Metodo para modificar un tipo de habitacion existente
    public function modificar(TipoHabitacionH $objeto) {
        try {
            $sql = "UPDATE u484426513_ms225.tipoHabitacionh 
                    SET nombre = ?, descripcion = ?
                    WHERE idTipo = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->nombre,
                $objeto->descripcion,
                $objeto->idTipo
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

}
?>
