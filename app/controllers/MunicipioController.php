<?php
require_once __DIR__ . '/../models/Municipio.php';

class MunicipioController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Municipio($pdo);
    }

    /* Mostrar la lista de municipios */
    public function index()
    {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $filters = [
            'departamento' => $_GET['departamento'] ?? '',
            'provincia' => $_GET['provincia'] ?? '',
            'distrito' => $_GET['distrito'] ?? '',
        ];

        $municipios = $this->model->getAll($limit, $offset, $filters);
        $total = $this->model->countAll($filters);
        $totalPages = ceil($total / $limit);

        include __DIR__ . '/../views/lista_municipios.php';
    }

    /* Mostrar formulario de registro */
    public function createForm()
    {
        include __DIR__ . '/../views/form_municipio.php';
    }

    /* Guardar nuevo registro */
    public function store($data)
    {
        $this->model->create($data);
        header("Location: index.php?action=index");
        exit;
    }
}
