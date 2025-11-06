<?php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Municipio.php';

class ClienteApiController
{
    private $clienteModel;
    private $municipioModel;

    public function __construct($pdo)
    {
        $this->clienteModel   = new Cliente($pdo);
        $this->municipioModel = new Municipio($pdo);
    }

    // endpoint principal del API
    public function procesar()
    {
        $tipo  = $_POST['tipo']  ?? $_GET['tipo']  ?? '';
        $token = $_POST['token'] ?? $_GET['token'] ?? '';
        $data  = $_POST['data']  ?? $_GET['data']  ?? '';

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
