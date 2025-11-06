<?php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Municipio.php';

class ClienteApiController
{
    private $clienteModel;
    private $municipioModel;
    private $pdo; // <--- agrega ESTA línea

    public function __construct($pdo)
    {
        $this->pdo = $pdo; // <--- agrega ESTA línea
        $this->clienteModel   = new Cliente($pdo);
        $this->municipioModel = new Municipio($pdo);
    }


    // endpoint principal del API
    public function procesar()
    {
        $tipo  = $_POST['tipo']  ?? $_GET['tipo']  ?? '';
        $token = $_POST['token'] ?? $_GET['token'] ?? '';
        $data  = $_POST['data']  ?? $_GET['data']  ?? '';

        if($tipo == "getLastToken")
{
    $stmt = $this->pdo->prepare("
        SELECT token, estado, expiracion 
        FROM tokens 
        WHERE id_cliente=1 
        ORDER BY id DESC LIMIT 1
    ");
    $stmt->execute();
    $tok = $stmt->fetch(PDO::FETCH_ASSOC);

    if($tok){
        echo json_encode([
            "status"=>true,
            "token"=>$tok['token'],
            "estado"=>$tok['estado'],
            "expiracion"=>$tok['expiracion']
        ]);
    } else {
        echo json_encode([
            "status"=>false,
            "msg"=>"No hay tokens"
        ]);
    }
    return;
}



        if($tipo == "verMunicipiosByDepartamento")
        {
            $token_arr  = explode("-", $token);
            $id_cliente = $token_arr[2];

            // validar cliente activo
            $cliente = $this->clienteModel->buscarClienteById($id_cliente);

            if(!$cliente || $cliente['estado'] != 1){
                echo json_encode(["status"=>false,"msg"=>"cliente no activo"]);
                return;
            }

            // buscar municipios por departamento
            $munis = $this->municipioModel->buscarPorDepartamento($data);

            echo json_encode([
                "status"=>true,
                "msg"=>"",
                "contenido"=>$munis
            ]);
            return;
        }

        

        // tipo no reconocido
        echo json_encode([
            "status"=>false,
            "msg"=>"Tipo no reconocido"
        ]);
    }
}
