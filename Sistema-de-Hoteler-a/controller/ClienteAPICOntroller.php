<?php
require_once __DIR__.'/../utils/validaciones.php';
require_once __DIR__.'/../accessData/ClientesDAO.php';
require_once __DIR__.'/../model/ClienteH.php';

class ClientesApiController {

    private $dao;

    public function __construct(){
        $this->dao = new ClientesDAO();
    }

    public function manejarRequest(){
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {

            case 'GET':
                // 🔍 Si recibe parámetro id, obtiene solo ese cliente
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $cliente = $this->dao->obtenerPorId($id);

                    if ($cliente) {
                        echo json_encode($cliente);
                    } else {
                        http_response_code(404);
                        echo json_encode(["error" => "Cliente no encontrado"]);
                    }
                } else {
                    // Obtener todos
                    $clientes = $this->dao->obtenerDatos();
                    echo json_encode($clientes);
                }
                break;

            case 'POST':
                $datos = json_decode(file_get_contents("php://input"), true);

                $validacion = validarCampos($datos, ['nombre', 'correo']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                $cliente = new ClienteH(null, $datos['nombre'], $datos['correo']);
                $this->dao->insertar($cliente);

                echo json_encode(["mensaje" => "Cliente insertado correctamente"]);
                break;

            case 'PUT':
                $datos = json_decode(file_get_contents("php://input"), true);

                $validacion = validarCampos($datos, ['idCliente', 'nombre', 'correo']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                $cliente = new ClienteH($datos['idCliente'], $datos['nombre'], $datos['correo']);
                $this->dao->modificar($cliente);

                echo json_encode(["mensaje" => "Cliente modificado correctamente"]);
                break;

            case 'DELETE':
                $datos = json_decode(file_get_contents("php://input"), true);

                if (!isset($datos['idCliente'])) {
                    echo json_encode(["error" => "Falta el ID del cliente"]);
                    return;
                }

                $idCliente = $datos['idCliente'];

                if ($this->dao->eliminar($idCliente)) {
                    echo json_encode(["mensaje" => "Cliente eliminado correctamente"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error al eliminar el cliente"]);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
        }
    }
}
?>
