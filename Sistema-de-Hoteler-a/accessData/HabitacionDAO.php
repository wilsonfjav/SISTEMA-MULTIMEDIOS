<?php

require_once __DIR__ . '/../misc/Conexion.php';
require_once __DIR__ . '/../model/HabitacionH.php';

class HabitacionDAO {

    private $pdo;

    // Constructor que establece la conexion con la base de datos
    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Metodo para obtener todas las habitaciones desde la base de datos
    public function obtenerDatos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM habitacionh");

            $result = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new HabitacionH(
                    $row['idHabitacion'],
                    $row['numero'],
                    $row['idTipo'],
                    $row['precio']
                );
            }

            return $result;
        } catch (PDOException $e) {
            return []; // En caso de error, se retorna un arreglo vacio
        }
    }

    // Metodo para obtener una habitacion especifica segun su ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.habitacionh WHERE idHabitacion = ?");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new HabitacionH(
                    $row['idHabitacion'],
                    $row['numero'],
                    $row['idTipo'],
                    $row['precio']
                );
            }

            return null; // Si no se encuentra, se retorna null
        } catch (PDOException $e) {
            return null;
        }
    }

    // Metodo para insertar una nueva habitacion
    public function insertar(HabitacionH $objeto) {
        try {
            $sql = "INSERT INTO u484426513_ms225.habitacionh(numero, idTipo, precio) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->numero,
                $objeto->idTipo,
                $objeto->precio
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Metodo para eliminar una habitacion por su ID
    public function eliminar($id) {
        try {
            //consulta 
            $sql = "DELETE FROM u484426513_ms225.habitacionh WHERE idHabitacion = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            //re
            return false;
        }
    }

    // Metodo para modificar los datos de una habitacion existente
    public function modificar(HabitacionH $objeto) {
        try {
            $sql = "UPDATE u484426513_ms225.habitacionh 
                    SET numero = ?, idTipo = ?, precio = ?
                    WHERE idHabitacion = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->numero,
                $objeto->idTipo,
                $objeto->precio,
                $objeto->idHabitacion
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}

?>
