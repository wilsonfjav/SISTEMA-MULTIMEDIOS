<?php
// Archivo: controller/PaqueteAPIController.php
require_once __DIR__ . '/../utils/validaciones.php';
require_once __DIR__ . '/../accessData/PaqueteDAO.php';
require_once __DIR__ . '/../model/PaqueteH.php';

class PaqueteAPIController
{

    private $dao;

    public function __construct()
    {
        $this->dao = new PaqueteDAO();
    }

    public function manejarRequest()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                // Obtener todos los paquetes
                $paquetes = $this->dao->obtenerDatos();
                echo json_encode($paquetes);
                break;

            case 'POST':
                // se obtiene el cuerpo del request en formato json
                $datos = json_decode(file_get_contents("php://input"), true);

                // se validan los campos requeridos antes de insertar
                $validacion = validarCampos($datos, ['nombre', 'descripcion', 'precio']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto paquete con id null porque es autoincremental
                $paquete = new PaqueteH(
                    null,
                    $datos['nombre'],
                    $datos['descripcion'],
                    $datos['precio']
                );

                // se llama al dao para insertar el paquete
                $this->dao->insertar($paquete);
                echo json_encode(["mensaje" => "paquete insertado correctamente"]);
                break;

            case 'PUT':
                // se obtiene el cuerpo como si fuera un formulario codificado
                parse_str(file_get_contents("php://input"), $datos);

                // se validan los campos requeridos para modificar
                $validacion = validarCampos($datos, ['idPaquete', 'nombre', 'descripcion', 'precio']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto paquete con los datos recibidos
                $paquete = new PaqueteH(
                    $datos['idPaquete'],
                    $datos['nombre'],
                    $datos['descripcion'],
                    $datos['precio']
                );

                // se llama al dao para realizar la modificacion
                $this->dao->modificar($paquete);
                echo json_encode(["mensaje" => "paquete modificado correctamente"]);
                break;

            case 'DELETE':
                // Eliminar paquete
                $datos = json_decode(file_get_contents("php://input"), true);

                $idPaquete = $datos['idPaquete'];

                $this->dao->eliminar($idPaquete);
                echo json_encode(["mensaje" => "Paquete eliminado correctamente"]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Metodo no permitido"]);
                break;
        }
    }
}
