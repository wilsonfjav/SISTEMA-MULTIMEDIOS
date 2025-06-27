<?php
require_once __DIR__ . '/../utils/validaciones.php';
require_once __DIR__ . '/../accessData/PagoDAO.php';
require_once __DIR__ . '/../model/PagoH.php';

class PagoAPIController
{

    private $dao;

    public function __construct()
    {
        $this->dao = new PagoDAO();
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

                // se validan los campos requeridos antes de insertar
                $validacion = validarCampos($datos, ['idReservacion', 'monto', 'metodoPago', 'fechaPago']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto pago con id null porque es autoincremental
                $pago = new PagoH(
                    null,
                    $datos['idReservacion'],
                    $datos['monto'],
                    $datos['metodoPago'],
                    $datos['fechaPago']
                );

                // se llama al dao para insertar el pago
                $this->dao->insertar($pago);
                echo json_encode(["mensaje" => "pago insertado correctamente"]);
                break;

            case 'PUT':
                // se obtiene el cuerpo como si fuera un formulario codificado
                parse_str(file_get_contents("php://input"), $datos);

                // se validan los campos requeridos para modificar
                $validacion = validarCampos($datos, ['idPago', 'idReservacion', 'monto', 'metodoPago', 'fechaPago']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto pago con los datos recibidos
                $pago = new PagoH(
                    $datos['idPago'],
                    $datos['idReservacion'],
                    $datos['monto'],
                    $datos['metodoPago'],
                    $datos['fechaPago']
                );

                // se llama al dao para realizar la modificacion
                $this->dao->modificar($pago);
                echo json_encode(["mensaje" => "pago modificado correctamente"]);
                break;


            case 'DELETE':
                $datos = json_decode(file_get_contents("php://input"), true);


                // Validar que se haya enviado el ID
                if (!isset($datos['idPago'])) {
                    echo json_encode(["error" => "Falta el ID para eliminar"]);
                    return;
                }

                $this->dao->eliminar($datos['idPago']);
                echo json_encode(["mensaje" => "Pago eliminado correctamente"]);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Metodo no permitido"]);
                break;
        }
    }
}
