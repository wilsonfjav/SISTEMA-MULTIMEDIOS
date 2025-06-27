<?php
// Permitir solicitudes desde cualquier origen (CORS)
// En desarrollo puedes usar '*'
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: http://localhost:5173");
// Si la solicitud es de tipo OPTIONS (preflight), termina aquí
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
// Cargar el controlador y ejecutar la lógica correspondiente
require_once __DIR__ . '/../controller/ClienteAPIController.php';

$controlador = new ClientesApicontroller();
$controlador->manejarRequest();
