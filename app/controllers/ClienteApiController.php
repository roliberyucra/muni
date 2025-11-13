<?php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Municipio.php';

class ClienteApiController
{
    private $clienteModel;
    private $municipioModel;
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->clienteModel   = new Cliente($pdo);
        $this->municipioModel = new Municipio($pdo);
    }

    public function procesar()
    {
        $tipo  = $_POST['tipo']  ?? $_GET['tipo']  ?? '';
        $token = $_POST['token'] ?? $_GET['token'] ?? '';
        $data  = $_POST['data']  ?? $_GET['data']  ?? '';

        /* ------- 1) generar token ------- */
        if ($tipo == "generarToken") {
    // 🔹 Desactivar anteriores
    $this->pdo->exec("UPDATE tokens SET estado=0 WHERE id_cliente=1");

    // 🔹 Generar token nuevo
    $random = bin2hex(random_bytes(10));
    $hoy    = date("Ymd");
    $token  = $random . "-" . $hoy . "-1";

    $now    = date("Y-m-d H:i:s");
    $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $stmt = $this->pdo->prepare("
        INSERT INTO tokens (id_cliente, token, fecha_guardado, expiracion, estado)
        VALUES (1, :token, :fecha_guardado, :expiracion, 1)
    ");
    $stmt->execute([
        ':token'          => $token,
        ':fecha_guardado' => $now,
        ':expiracion'     => $expira
    ]);

    echo json_encode([
        "status" => true,
        "token"  => $token,
        "expira" => $expira
    ]);
    return;
}


        /* ------- 2) obtener último token ------- */
        if($tipo == "getLastToken")
        {
            $stmt= $this->pdo->query("SELECT token,estado,expiracion FROM tokens WHERE id_cliente=1 ORDER BY id DESC LIMIT 1");
            $tok = $stmt->fetch(\PDO::FETCH_ASSOC);

            echo json_encode($tok ? ["status"=>true]+$tok : ["status"=>false,"msg"=>"No hay tokens"]);
            return;
        }

        /* ------- 3) buscar municipios ------- */
        if($tipo == "verMunicipiosByDepartamento")
        {
            // validar token
            $stmt = $this->pdo->prepare("SELECT estado,expiracion FROM tokens WHERE token=? LIMIT 1");
            $stmt->execute([$token]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$row){ echo json_encode(["status"=>false,"msg"=>"token no existe"]); return; }
            if($row['estado']!=1){ echo json_encode(["status"=>false,"msg"=>"token inactivo"]); return; }
            if(strtotime($row['expiracion'])<time()){ echo json_encode(["status"=>false,"msg"=>"token expirado"]); return; }

            // ok -> devolver municipios
            $munis = $this->municipioModel->buscarPorDepartamento($data);

            echo json_encode(["status"=>true,"contenido"=>$munis]);
            return;
        }

        /* ------- default ------- */
        echo json_encode(["status"=>false,"msg"=>"Tipo no reconocido"]);
    }
}
