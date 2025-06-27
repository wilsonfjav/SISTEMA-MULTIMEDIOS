<?php
// === ServicioExtraApiController.php ===
require_once __DIR__ . '/../utils/validaciones.php';
require_once __DIR__ . '/../accessData/ServicioExtraDAO.php';
require_once __DIR__ . '/../model/ServicioExtraH.php';

class ServicioExtraAPIController
{

    private $dao;

    public function __construct()
    {
        $this->dao = new ServicioExtraDAO();
    }

    public function manejarRequest()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                // Obtener todos los servicios extra
                $data = $this->dao->obtenerDatos();
                echo json_encode($data);
                break;

            case 'POST':
                // se obtiene el cuerpo del request en formato json
                $datos = json_decode(file_get_contents("php://input"), true);

                // se validan los campos requeridos antes de insertar
                $validacion = validarCampos($datos, ['nombre', 'descripcion']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto servicio extra con id null porque es autoincremental
                $servicio = new ServicioExtraH(
                    null,
                    $datos['nombre'],
                    $datos['descripcion']
                );

                // se inserta en la base de datos
                $this->dao->insertar($servicio);
                echo json_encode(["mensaje" => "servicio extra insertado"]);
                break;

            case 'PUT':
                // se obtiene el cuerpo como si fuera formulario codificado
                parse_str(file_get_contents("php://input"), $datos);

                // se validan los campos requeridos para modificar
                $validacion = validarCampos($datos, ['idServicio', 'nombre', 'descripcion']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto servicio extra con los datos recibidos
                $servicio = new ServicioExtraH(
                    $datos['idServicio'],
                    $datos['nombre'],
                    $datos['descripcion']
                );

                // se modifica en la base de datos
                $this->dao->modificar($servicio);
                echo json_encode(["mensaje" => "servicio extra modificado"]);
                break;


            case 'DELETE':
                // Eliminar servicio extra
                $datos = json_decode(file_get_contents("php://input"), true);

                $this->dao->eliminar($datos['idServicio']);
                echo json_encode(["mensaje" => "Servicio extra eliminado"]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Metodo no permitido"]);
                break;
        }
    }
}
