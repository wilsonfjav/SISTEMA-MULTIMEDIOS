<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Incluir el controlador API correspondiente
require_once './../controller/PaqueteApiController.php';

// Crear instancia del controlador y manejar la solicitud
$controlador = new PaqueteApiController();
$controlador->manejarRequest();
