<?php
// === TipoHabitacionAPIController.php ===
require_once __DIR__.'/../utils/validaciones.php';
require_once __DIR__.'/../accessData/TipoHabitacionDAO.php';
require_once __DIR__.'/../model/TipoHabitacionH.php';

class TipoHabitacionAPIController {

    private $dao;

    public function __construct() {
        $this->dao = new TipoHabitacionDAO();
    }

    public function manejarRequest() {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                // Obtener todos los registros
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

    // se crea el objeto tipo habitacion con id null porque es autoincremental
    $tipo = new TipoHabitacionH(
        null,
        $datos['nombre'],
        $datos['descripcion']
    );

    // se inserta el nuevo tipo de habitacion en la base de datos
    $this->dao->insertar($tipo);
    echo json_encode(["mensaje" => "tipo habitacion insertado"]);
    break;

case 'PUT':
    // se obtiene el cuerpo como si fuera formulario codificado
    parse_str(file_get_contents("php://input"), $datos);

    // se validan los campos requeridos para modificar
    $validacion = validarCampos($datos, ['idTipo', 'nombre', 'descripcion']);
    if ($validacion !== true) {
        echo json_encode(["error" => $validacion]);
        return;
    }

    // se crea el objeto tipo habitacion con los datos recibidos
    $tipo = new TipoHabitacionH(
        $datos['idTipo'],
        $datos['nombre'],
        $datos['descripcion']
    );

    // se actualiza el tipo de habitacion en la base de datos
    $this->dao->modificar($tipo);
    echo json_encode(["mensaje" => "tipo habitacion modificado"]);
    break;

            case 'DELETE':
                // Eliminar registro
               $datos = json_decode(file_get_contents("php://input"), true);

                $this->dao->eliminar($datos['idTipo']);
                echo json_encode(["mensaje" => "Tipo habitacion eliminado"]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Metodo no permitido"]);
                break;
        }
    }
}
?>
