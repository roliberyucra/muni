<?php
require_once __DIR__ . '/../models/Token.php';
require_once __DIR__ . '/../models/Cliente.php';

class TokenController
{
    private $model;
    private $clienteModel;

    public function __construct($pdo)
    {
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
}
