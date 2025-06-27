<?php
// === UsuarioAPIController.php ===
require_once __DIR__ . '/../utils/validaciones.php';
require_once __DIR__ . '/../accessData/UsuarioDAO.php';
require_once __DIR__ . '/../model/UsuarioH.php';

class UsuarioAPIController
{

    private $dao;

    public function __construct()
    {
        $this->dao = new UsuarioDAO();
    }

    public function manejarRequest()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                // Obtener todos los usuarios
                $data = $this->dao->obtenerDatos();
                echo json_encode($data);
                break;

            case 'POST':
                // se obtiene el cuerpo del request en formato json
                $datos = json_decode(file_get_contents("php://input"), true);

                // se validan los campos requeridos antes de insertar
                $validacion = validarCampos($datos, ['nombreUsuario', 'claveHash', 'rol', 'estado']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto usuario con id null porque es autoincremental
                $usuario = new UsuarioH(
                    null,
                    $datos['nombreUsuario'],
                    $datos['claveHash'],
                    $datos['rol'],
                    $datos['estado']
                );

                // se inserta el usuario en la base de datos
                $this->dao->insertar($usuario);
                echo json_encode(["mensaje" => "usuario insertado"]);
                break;

            case 'PUT':
                // se obtiene el cuerpo como si fuera formulario codificado
                parse_str(file_get_contents("php://input"), $datos);

                // se validan los campos requeridos para modificar
                $validacion = validarCampos($datos, ['idUsuario', 'nombreUsuario', 'claveHash', 'rol', 'estado']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto usuario con los datos recibidos
                $usuario = new UsuarioH(
                    $datos['idUsuario'],
                    $datos['nombreUsuario'],
                    $datos['claveHash'],
                    $datos['rol'],
                    $datos['estado']
                );

                // se actualiza el usuario en la base de datos
                $this->dao->modificar($usuario);
                echo json_encode(["mensaje" => "usuario modificado"]);
                break;


            case 'DELETE':
                // Eliminar usuario
                $datos = json_decode(file_get_contents("php://input"), true);

                $this->dao->eliminar($datos['idUsuario']);
                echo json_encode(["mensaje" => "Usuario eliminado"]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Metodo no permitido"]);
                break;
        }
    }
}
