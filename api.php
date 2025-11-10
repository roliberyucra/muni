<?php
echo json_encode(["tipo_llega"=>$tipo]);
exit;


error_reporting(E_ALL);
ini_set('display_errors',1);

require_once __DIR__."/config/config.php";
require_once __DIR__."/app/controllers/ClienteApiController.php";

header("Content-Type: application/json; charset=utf-8");

// crear controller
$controller = new ClienteApiController($pdo);

// procesar y responder directamente (la clase hace echo)
$controller->procesar();

