<?php

require_once __DIR__ . '/../utils/validaciones.php';
require_once __DIR__ . '/../accessData/DetalleReservacionDAO.php';
require_once __DIR__ . '/../model/DetalleReservacionH.php';

class DetalleReservacionAPIController
{

    private $dao;

    public function __construct()
    {
        $this->dao = new DetalleReservacionDAO();
    }

    public function manejarRequest()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {

            case 'GET':
                // Obtener todos los detalles
                echo json_encode($this->dao->obtenerDatos());
                break;

            case 'POST':
                // obtenemos JSON
                $datos = json_decode(file_get_contents("php://input"), true);

                // registro de depuración
                error_log("POST DetalleReservacion recibe: " . print_r($datos, true));

                $validacion = validarCampos($datos, ['idReservacion', 'idHabitacion']);
                if ($validacion !== true) {
                    http_response_code(400);
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                $detalle = new DetalleReservacionH(
                    null,
                    $datos['idReservacion'],
                    $datos['idHabitacion']
                );

                // llamamos al DAO y comprobamos éxito
                $ok = $this->dao->insertar($detalle);
                if ($ok) {
                    http_response_code(201);
                    echo json_encode(["mensaje" => "Detalle insertado correctamente"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error interno al insertar detalle"]);
                }
                break;



            case 'PUT':
                // Leemos JSON en lugar de parse_str
                $datos = json_decode(file_get_contents("php://input"), true);
                $validacion = validarCampos($datos, ['idDetalle', 'idReservacion', 'idHabitacion']);
                if ($validacion !== true) {
                    http_response_code(400);
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                $detalle = new DetalleReservacionH(
                    $datos['idDetalle'],
                    $datos['idReservacion'],
                    $datos['idHabitacion']
                );
                $this->dao->modificar($detalle);
                echo json_encode(["mensaje" => "Detalle modificado correctamente"]);
                break;

            case 'DELETE':
                // Leemos JSON en lugar de parse_str
                $datos = json_decode(file_get_contents("php://input"), true);
                if (empty($datos['idDetalle'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Falta idDetalle para eliminar"]);
                    return;
                }

                $this->dao->eliminar($datos['idDetalle']);
                echo json_encode(["mensaje" => "Detalle eliminado correctamente"]);
                break;
            default:
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
                break;
        }
    }
}
