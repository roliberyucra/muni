<?php

class Cliente
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarClienteById($id)
{
    $stmt = $this->pdo->prepare("SELECT * FROM client_api WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // Obtener todos los clientes (CRUD normal)
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM client_api ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ➕ Crear cliente
    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO client_api (ruc, razon_social, telefono, correo, estado, fecha_registro)
            VALUES (:ruc, :razon_social, :telefono, :correo, :estado, CURRENT_TIMESTAMP)
        ");
        $stmt->execute([
            ':ruc' => $data['ruc'],
            ':razon_social' => $data['razon_social'],
            ':telefono' => $data['telefono'],
            ':correo' => $data['correo'],
            ':estado' => $data['estado']
        ]);
    }

    // Buscar cliente por ID (para API)
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM client_api WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
