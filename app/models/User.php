<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Buscar usuario por email
    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear nuevo usuario
    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO usuarios (email, password, nombre) 
            VALUES (:email, :password, :nombre)
        ");
        return $stmt->execute($data);
    }
}
