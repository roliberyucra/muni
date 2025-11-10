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
            // validar cliente activo
$cliente = $this->clienteModel->buscarClienteById($id_cliente);

if(!$cliente || $cliente['estado'] != 1){
    echo json_encode(["status"=>false,"msg"=>"cliente no activo"]);
    return;
}

// validar token activo y no expirado
$stmt = $this->pdo->prepare("
    SELECT estado, expiracion 
    FROM tokens 
    WHERE token=? AND id_cliente=1 
    ORDER BY id DESC LIMIT 1
");
$stmt->execute([$token]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row){
    echo json_encode(["status"=>false,"msg"=>"token no registrado"]);
    return;
}

if($row['estado'] != 1){
    echo json_encode(["status"=>false,"msg"=>"token inactivo"]);
    return;
}

if(strtotime($row['expiracion']) < time()){
    echo json_encode(["status"=>false,"msg"=>"token expirado"]);
    return;
}

        }

        if($tipo == "generarToken")
{
    // desactiva anteriores
    $this->pdo->exec("UPDATE tokens SET estado=0 WHERE id_cliente=1");

    $random  = bin2hex(random_bytes(10));
    $hoy     = date("Ymd");
    $token   = $random."-".$hoy."-1";

    $now      = date("Y-m-d H:i:s");
    $expira   = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $stmt = $this->pdo->prepare("
        INSERT INTO tokens (id_cliente, token, fecha_registro, expiracion, estado)
        VALUES (1, :token, :fecha_registro, :expiracion, 1)
    ");
    $stmt->execute([
        ':token'          => $token,
        ':fecha_registro' => $now,
        ':expiracion'     => $expira
    ]);

    echo json_encode([
        "status" => true,
        "token"  => $token,
        "expira" => $expira
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
