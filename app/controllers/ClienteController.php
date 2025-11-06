<?php
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController
{
    private $pdo;
    private $model;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;                // Guardamos la conexión aquí
        $this->model = new Cliente($pdo); // Modelo del cliente
    }

    /* Listar todos los clientes */
    public function index()
    {
        $clientes = $this->model->getAll();
        include __DIR__ . '/../views/lista_clientes.php';
    }

    /* Mostrar formulario */
    public function createForm()
    {
        include __DIR__ . '/../views/form_cliente.php';
    }

    /* Guardar nuevo cliente */
    public function store($data)
    {
        $this->model->create([
            'ruc'          => $data['ruc'],
            'razon_social' => $data['razon_social'],
            'telefono'     => $data['telefono'],
            'correo'       => $data['correo'],
            'estado'       => isset($data['estado']) ? (int)$data['estado'] : 1
        ]);

        header("Location: index.php?action=clientes");
        exit;
    }

    /* Procesar solicitudes desde la API */
    public function procesarSolicitudApi($tipo, $token, $data)
    {
        header('Content-Type: application/json');

        if (empty($tipo) || empty($token)) {
            return json_encode(["status" => false, "msg" => "Parámetros incompletos."]);
        }

        // Extraer ID del cliente desde el token
        $token_arr = explode("-", $token);
        $id_cliente = $token_arr[2] ?? null;
        
        // Si la parte del ID no existe, devolvemos el estado FALSE
        if (!$id_cliente) {
            return json_encode(["status" => false, "msg" => "Token no válido."]);
        }

        // Verificar cliente activo
        $stmt = $this->pdo->prepare("SELECT * FROM client_api WHERE id = :id");
        $stmt->execute([':id' => $id_cliente]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verificar si el estado es diferente a 1, entonces no existe o no está activo
        if (!$cliente || $cliente['estado'] != 1) {
            return json_encode(["status" => false, "msg" => "Cliente no activo o no encontrado."]);
        }

        // Según el tipo de solicitud
        switch ($tipo) {
            case 'verMunicipioByNombre':
                if (empty($data)) {
                    return json_encode(["status" => false, "msg" => "Debe enviar un nombre o texto de búsqueda."]);
                }

                $stmt = $this->pdo->prepare("
                    SELECT * FROM municipios 
                    WHERE departamento LIKE :q 
                       OR provincia LIKE :q 
                       OR distrito LIKE :q 
                       OR nombre LIKE :q
                ");
                $stmt->execute([':q' => "%$data%"]);
                $municipios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return json_encode(["status" => true, "msg" => "", "contenido" => $municipios]);

            default:
                return json_encode(["status" => false, "msg" => "Tipo de solicitud no reconocido."]);
        }
    }

    /*
    public function procesarSolicitudApi($tipo, $token, $data)
{
    header('Content-Type: application/json');

    if (empty($tipo) || empty($token)) {
        return json_encode(["status" => false, "msg" => "Parámetros incompletos."]);
    }

    // Extraer ID del cliente desde el token
    $token_arr = explode("-", $token);
    $id_cliente = $token_arr[2] ?? null;

    if (!$id_cliente) {
        return json_encode(["status" => false, "msg" => "Token no válido (sin ID de cliente)."]);
    }

    // Verificar el token completo en la base de datos
    $stmt = $this->pdo->prepare("
        SELECT t.*, c.estado AS estado_cliente
        FROM tokens t
        JOIN client_api c ON c.id = t.id_cliente
        WHERE t.token = :token AND t.estado = 1
    ");
    $stmt->execute([':token' => $token]);
    $tokenInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tokenInfo) {
        return json_encode(["status" => false, "msg" => "Token no encontrado o inactivo."]);
    }

    if ($tokenInfo['estado_cliente'] != 1) {
        return json_encode(["status" => false, "msg" => "Cliente asociado al token no está activo."]);
    }

    // Procesar solicitud según el tipo
    switch ($tipo) {
        case 'verMunicipioByNombre':
            if (empty($data)) {
                return json_encode(["status" => false, "msg" => "Debe enviar un nombre o texto de búsqueda."]);
            }

            $stmt = $this->pdo->prepare("
                SELECT * FROM municipios 
                WHERE departamento LIKE :q 
                   OR provincia LIKE :q 
                   OR distrito LIKE :q 
                   OR nombre LIKE :q
            ");
            $stmt->execute([':q' => "%$data%"]);
            $municipios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode(["status" => true, "msg" => "", "contenido" => $municipios]);

        default:
            return json_encode(["status" => false, "msg" => "Tipo de solicitud no reconocido."]);
    }
}
    */

}
