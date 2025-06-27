<?php

require_once __DIR__ .'/../misc/Conexion.php';
require_once __DIR__ . '/../model/UsuarioH.php';

class UsuarioDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Conexion::conectar();
    }

    // Metodo para obtener todos los usuarios
    public function obtenerDatos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM usuarioh");

            $result = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new UsuarioH(
                    $row['idUsuario'],
                    $row['nombreUsuario'],
                    $row['claveHash'],
                    $row['rol'],
                    $row['estado']
                );
            }

            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }

    // Metodo para obtener un usuario por su ID
    public function obtenerPorId($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM u484426513_ms225.usuarioh WHERE idUsuario = ?");
            $stmt->execute([$id]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return new UsuarioH(
                    $row['idUsuario'],
                    $row['nombreUsuario'],
                    $row['claveHash'],
                    $row['rol'],
                    $row['estado']
                );
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Metodo para insertar un nuevo usuario
    public function insertar(UsuarioH $objeto) {
        try {
            $sql = "INSERT INTO u484426513_ms225.usuarioh(nombreUsuario, claveHash, rol, estado) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->nombreUsuario,
                $objeto->claveHash,
                $objeto->rol,
                $objeto->estado
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Metodo para eliminar un usuario por ID
    public function eliminar($id) {
        try {
            $sql = "DELETE FROM u484426513_ms225.usuarioh WHERE idUsuario = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Metodo para modificar un usuario existente
    public function modificar(UsuarioH $objeto) {
        try {
            $sql = "UPDATE u484426513_ms225.usuarioh 
                    SET nombreUsuario = ?, claveHash = ?, rol = ?, estado = ?
                    WHERE idUsuario = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $objeto->nombreUsuario,
                $objeto->claveHash,
                $objeto->rol,
                $objeto->estado,
                $objeto->idUsuario
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

}
?>
