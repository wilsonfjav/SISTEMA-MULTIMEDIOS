<?php
require_once __DIR__ . '/../utils/validaciones.php';
require_once __DIR__ . '/../accessData/MantenimientoHabitacionDAO.php';
require_once __DIR__ . '/../model/MantenimientoHabitacionH.php';

class MantenimientoHabitacionAPIController
{

    private $dao;

    public function __construct()
    {
        $this->dao = new MantenimientoHabitacionDAO();
    }

    public function manejarRequest()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                echo json_encode($this->dao->obtenerDatos());
                break;

            case 'POST':
                // se obtiene el cuerpo del request en formato json
                $datos = json_decode(file_get_contents("php://input"), true);

                // se validan los campos requeridos
                $validacion = validarCampos($datos, ['idHabitacion', 'descripcion', 'fecha']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto mantenimientohabitacion con id null porque es autoincremental
                $mantenimiento = new MantenimientoHabitacionH(
                    null,
                    $datos['idHabitacion'],
                    $datos['descripcion'],
                    $datos['fecha']
                );

                // se inserta el nuevo mantenimiento
                $this->dao->insertar($mantenimiento);
                echo json_encode(["mensaje" => "mantenimiento insertado correctamente"]);
                break;

            case 'PUT':
                // se obtiene el cuerpo como si fuera un formulario codificado
                parse_str(file_get_contents("php://input"), $datos);

                // se validan los campos requeridos para modificar
                $validacion = validarCampos($datos, ['idMantenimiento', 'idHabitacion', 'descripcion', 'fecha']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto mantenimientohabitacion con los datos recibidos
                $mantenimiento = new MantenimientoHabitacionH(
                    $datos['idMantenimiento'],
                    $datos['idHabitacion'],
                    $datos['descripcion'],
                    $datos['fecha']
                );

                // se realiza la modificacion del mantenimiento
                $this->dao->modificar($mantenimiento);
                echo json_encode(["mensaje" => "mantenimiento modificado correctamente"]);
                break;

            case 'DELETE':
                $datos = json_decode(file_get_contents("php://input"), true);


                // Validar que se haya enviado el ID
                if (!isset($datos['idMantenimiento'])) {
                    echo json_encode(["error" => "Falta el ID para eliminar"]);
                    return;
                }

                $this->dao->eliminar($datos['idMantenimiento']);
                echo json_encode(["mensaje" => "Mantenimiento eliminado correctamente"]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Metodo no permitido"]);
                break;
        }
    }
}
