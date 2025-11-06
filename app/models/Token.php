<?php
class Token
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /* 📋 Listar todos los tokens con su cliente */
    public function getAll()
    {
        $stmt = $this->pdo->query("
            SELECT t.*, c.razon_social 
            FROM tokens t 
            JOIN client_api c ON c.id = t.id_cliente
            ORDER BY t.id DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ➕ Crear nuevo token */
    public function create($idCliente)
    {
        $random = bin2hex(random_bytes(10));     // parte aleatoria
        $fechaForToken = date("Ymd");            // fecha para el token (YMD)
        $fechaRegistro = date("Y-m-d H:i:s");    // timestamp completo

        // token con formato random-fecha-id
        $token = "{$random}-{$fechaForToken}-{$idCliente}";

        $stmt = $this->pdo->prepare("
            INSERT INTO tokens (id_cliente, token, fecha_registro, estado)
            VALUES (:id_cliente, :token, :fecha_registro, 1)
        ");
        $stmt->execute([
            ':id_cliente' => $idCliente,
            ':token' => $token,
            ':fecha_registro' => $fechaRegistro
        ]);

        return $token; // devuelve el token generado
    }

    /* 🧾 Registrar uso del token (para contar peticiones API) */
    public function registrarUso($token, $tipo)
    {
        // Buscar ID del token existente
        $stmt = $this->pdo->prepare("SELECT id FROM tokens WHERE token = :token LIMIT 1");
        $stmt->execute([':token' => $token]);
        $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$tokenData) {
            return false; // token inexistente
        }

        $id_token = $tokenData['id'];

        // Verificar si ya existe un conteo para este mes y tipo
        $check = $this->pdo->prepare("
            SELECT id, contador 
            FROM count_request 
            WHERE id_token = :id_token 
              AND tipo = :tipo 
              AND MONTH(mes) = MONTH(CURDATE()) 
              AND YEAR(mes) = YEAR(CURDATE())
        ");
        $check->execute([':id_token' => $id_token, ':tipo' => $tipo]);
        $row = $check->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Actualizar contador existente
            $update = $this->pdo->prepare("UPDATE count_request SET contador = contador + 1 WHERE id = :id");
            $update->execute([':id' => $row['id']]);
        } else {
            // Insertar nuevo registro
            $insert = $this->pdo->prepare("
                INSERT INTO count_request (id_token, contador, tipo, mes)
                VALUES (:id_token, 1, :tipo, CURDATE())
            ");
            $insert->execute([':id_token' => $id_token, ':tipo' => $tipo]);
        }

        return true;
    }
}
