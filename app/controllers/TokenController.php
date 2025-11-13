<?php
require_once __DIR__ . '/../models/Token.php';
require_once __DIR__ . '/../models/Cliente.php';

class TokenController
{
    private $model;
    private $clienteModel;
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->model = new Token($pdo);
        $this->clienteModel = new Cliente($pdo);
    }

    public function index()
    {
        $tokens = $this->model->getAll();
        include __DIR__ . '/../views/lista_tokens.php';
    }

    public function createForm()
    {
        $clientes = $this->clienteModel->getAll();
        include __DIR__ . '/../views/form_token.php';
    }

    public function store($data)
    {
        $this->model->create($data['id_cliente']);
        header("Location: index.php?action=tokens");
        exit;
    }

    /* ✅ NUEVO: Formulario de edición */
    public function editForm($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tokens WHERE id = ?");
        $stmt->execute([$id]);
        $token = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$token) {
            die("Token no encontrado");
        }

        include __DIR__ . '/../views/edit_token.php';
    }

    /* ✅ NUEVO: Guardar cambios */
    public function update($data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE tokens
            SET token = :token, estado = :estado, expiracion = :expiracion
            WHERE id = :id
        ");
        $stmt->execute([
            ':token' => $data['token'],
            ':estado' => $data['estado'],
            ':expiracion' => $data['expiracion'],
            ':id' => $data['id']
        ]);

        header("Location: index.php?action=tokens");
        exit;
    }
}
