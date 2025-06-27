<?php
require_once __DIR__ . '/../utils/validaciones.php';
require_once __DIR__ . '/../accessData/HabitacionPaqueteDAO.php';
require_once __DIR__ . '/../model/HabitacionPaqueteH.php';

class HabitacionPaqueteAPIController
{

    private $dao;

    public function __construct()
    {
        $this->dao = new HabitacionPaqueteDAO();
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
                $validacion = validarCampos($datos, ['idHabitacion', 'idPaquete']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto habitacionpaquete
                $habitacionPaquete = new HabitacionPaqueteH(
                    $datos['idHabitacion'],
                    $datos['idPaquete']
                );

                // se inserta el nuevo registro
                $this->dao->insertar($habitacionPaquete);
                echo json_encode(["mensaje" => "registro insertado correctamente"]);
                break;


            case 'PUT':
                // se obtiene el cuerpo en formato JSON
                $datos = json_decode(file_get_contents("php://input"), true);

                // validamos que sea un array y luego los campos requeridos para modificar
                if (!is_array($datos)) {
                    http_response_code(400);
                    echo json_encode(["error" => "JSON mal formado"]);
                    return;
                }
                $validacion = validarCampos($datos, [
                    'idHabitacionAnterior',
                    'idPaqueteAnterior',
                    'idHabitacion',
                    'idPaquete'
                ]);
                if ($validacion !== true) {
                    http_response_code(400);
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto habitacionpaquete con los nuevos datos
                $habitacionPaquete = new HabitacionPaqueteH(
                    $datos['idHabitacion'],
                    $datos['idPaquete']
                );

                // se realiza la modificacion usando los valores anteriores como referencia
                $this->dao->modificar(
                    $habitacionPaquete,
                    $datos['idHabitacionAnterior'],
                    $datos['idPaqueteAnterior']
                );
                echo json_encode(["mensaje" => "registro modificado correctamente"]);
                break;

            case 'DELETE':
                $datos = json_decode(file_get_contents("php://input"), true);
                if (!isset($datos['idHabitacion'], $datos['idPaquete'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Faltan datos para eliminar"]);
                    return;
                }
                $this->dao->eliminar($datos['idHabitacion'], $datos['idPaquete']);
                echo json_encode(["mensaje" => "Registro eliminado correctamente"]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Metodo no permitido"]);
                break;
        }
    }
}
