<?php

require_once __DIR__ . '/../utils/validaciones.php';
require_once __DIR__ . '/../accessData/ConsumoDAO.php';
require_once __DIR__ . '/../model/ConsumoH.php';

class ConsumoApiController
{

    private $dao;

    public function __construct()
    {
        $this->dao = new ConsumoDAO();
    }

    public function manejarRequest()
    {
        $metodo = $_SERVER['REQUEST_METHOD'];

        switch ($metodo) {
            case 'GET':
                // Obtener todos los consumos
                $consumos = $this->dao->obtenerDatos();
                echo json_encode($consumos);
                break;



            case 'POST':
                // se obtiene el cuerpo del request en formato json
                $datos = json_decode(file_get_contents("php://input"), true);

                // se validan los campos requeridos antes de insertar
                $validacion = validarCampos($datos, ['idReservacion', 'idServicio', 'cantidad', 'fecha']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea el objeto consumo con id null porque es autoincremental
                $nuevo = new ConsumoH(
                    null,
                    $datos['idReservacion'],
                    $datos['idServicio'],
                    $datos['cantidad'],
                    $datos['fecha']
                );

                $this->dao->insertar($nuevo);
                echo json_encode(["mensaje" => "Consumo insertado correctamente"]);
                break;


            case 'PUT':
                // Decodificamos JSON en lugar de parse_str
                $datos = json_decode(file_get_contents("php://input"), true);

                // Validamos que idConsumo y restantes campos existan
                $validacion = validarCampos($datos, ['idConsumo', 'idReservacion', 'idServicio', 'cantidad', 'fecha']);
                if ($validacion !== true) {
                    http_response_code(400);
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                $modificado = new ConsumoH(
                    $datos['idConsumo'],
                    $datos['idReservacion'],
                    $datos['idServicio'],
                    $datos['cantidad'],
                    $datos['fecha']
                );

                if ($this->dao->modificar($modificado)) {
                    echo json_encode(["mensaje" => "Consumo modificado correctamente"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error interno al modificar"]);
                }
                break;


            case 'DELETE':
                // Decodificamos JSON
                $datos = json_decode(file_get_contents("php://input"), true);

                if (!isset($datos['idConsumo'])) {
                    http_response_code(400);
                    echo json_encode(["error" => "Falta idConsumo para eliminar"]);
                    return;
                }

                if ($this->dao->eliminar($datos['idConsumo'])) {
                    echo json_encode(["mensaje" => "Consumo eliminado correctamente"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error interno al eliminar"]);
                }
                break;
        }
    }
}
