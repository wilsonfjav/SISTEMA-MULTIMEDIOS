<?php
require_once __DIR__.'/../utils/validaciones.php';
require_once __DIR__.'/../accessData/ClientesDAO.php';
require_once __DIR__.'/../model/ClienteH.php';


class ClientesApiController{


    private $dao;

    public function __construct(){
        $this->dao = new ClientesDAO();
    }

    public function manejarRequest(){
        $metodo = $_SERVER['REQUEST_METHOD'];

        //POST, GET, PUT DELETE
        switch ($metodo) 
        {

            case 'GET':
                // Obtener todos
                $clientes = $this->dao->obtenerDatos();
                echo json_encode($clientes);
                break;

            case 'POST':
                // se obtiene el cuerpo del request en formato json
                $datos = json_decode(file_get_contents("php://input"), true);

                // se validan los campos requeridos antes de insertar
                $validacion = validarCampos($datos, ['nombre', 'correo']);
                if ($validacion !== true) {
                    // si falta algun campo, se responde con un mensaje de error
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                // se crea un objeto cliente con id null porque es autoincremental
                $cliente = new ClienteH(null, $datos['nombre'], $datos['correo']);

                // se llama al dao para insertar el cliente
                $this->dao->insertar($cliente);

                // se devuelve mensaje de exito
                echo json_encode(["mensaje" => "cliente insertado correctamente"]);
                break;

            //se modificó el método
            case 'PUT':
                // leer como JSON correctamente
                $datos = json_decode(file_get_contents("php://input"), true);

                $validacion = validarCampos($datos, ['idCliente', 'nombre', 'correo']);
                if ($validacion !== true) {
                    echo json_encode(["error" => $validacion]);
                    return;
                }

                $cliente = new ClienteH($datos['idCliente'], $datos['nombre'], $datos['correo']);
                $this->dao->modificar($cliente);

                echo json_encode(["mensaje" => "cliente modificado correctamente"]);
                break;



            //Tambien se modificó
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

        }
        
    }


}

?>