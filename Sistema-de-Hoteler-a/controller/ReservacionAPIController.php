<?php
// === ReservacionApiController.php ===+
require_once __DIR__ . '/../utils/validaciones.php';
require_once __DIR__ . '/../accessData/ReservacionDAO.php';
require_once __DIR__ . '/../model/ReservacionH.php';

class ReservacionAPIController
{

    private $dao;

    public function __construct()
    {
        $this->dao = new ReservacionDAO();
    }

    public function manejarRequest()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                // Obtener todas las reservaciones
                $data = $this->dao->obtenerDatos();
                echo json_encode($data);
                break;

            case 'POST':
                // se obtiene el cuerpo del request en formato json
                $datos = json_decode(file_get_contents("php://input"), true);

                // se validan los campos requeridos antes de insertar
                $validacion = validarCampos($datos, ['idCliente', 'fechaInicio', 'fechaFin', 'estado']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto reservacion con id null porque es autoincremental
                $objeto = new ReservacionH(
                    null,
                    $datos['idCliente'],
                    $datos['fechaInicio'],
                    $datos['fechaFin'],
                    $datos['estado']
                );

                // se llama al dao para insertar la reservacion
                $this->dao->insertar($objeto);
                echo json_encode(["mensaje" => "reservacion insertada"]);
                break;

            case 'PUT':
                // se obtiene el cuerpo como si fuera un formulario codificado
                parse_str(file_get_contents("php://input"), $datos);

                // se validan los campos requeridos para modificar
                $validacion = validarCampos($datos, ['idReservacion', 'idCliente', 'fechaInicio', 'fechaFin', 'estado']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto reservacion con los datos recibidos
                $objeto = new ReservacionH(
                    $datos['idReservacion'],
                    $datos['idCliente'],
                    $datos['fechaInicio'],
                    $datos['fechaFin'],
                    $datos['estado']
                );

                // se llama al dao para realizar la modificacion
                $this->dao->modificar($objeto);
                echo json_encode(["mensaje" => "reservacion modificada"]);
                break;

            case 'DELETE':
                // Eliminar reservacion
                $datos = json_decode(file_get_contents("php://input"), true);
                if (isset($datos['idReservacion'])) {
                    $this->dao->eliminar($datos['idReservacion']);
                    echo json_encode(["mensaje" => "Reservacion eliminada"]);
                } else {
                    echo json_encode(["error" => "Falta el idReservacion"]);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(["error" => "Metodo no permitido"]);
                break;
        }
    }
}
