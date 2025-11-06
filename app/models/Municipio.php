<?php
class Municipio
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorDepartamento($dep)
{
    $stmt = $this->pdo->prepare("SELECT * FROM municipios WHERE departamento LIKE :dep");
    $stmt->execute([':dep' => "%$dep%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    
    
    /* Obtener municipios con filtros y paginación */
    public function getAll($limit, $offset, $filters = [])
    {
        $where = [];
        $params = [];

        if (!empty($filters['departamento'])) {
            $where[] = "departamento LIKE :departamento";
            $params[':departamento'] = "%" . $filters['departamento'] . "%";
        }
        if (!empty($filters['provincia'])) {
            $where[] = "provincia LIKE :provincia";
            $params[':provincia'] = "%" . $filters['provincia'] . "%";
        }
        if (!empty($filters['distrito'])) {
            $where[] = "distrito LIKE :distrito";
            $params[':distrito'] = "%" . $filters['distrito'] . "%";
        }

        $whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

        $sql = "SELECT * FROM municipios $whereSql ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Contar registros totales (para la paginación) */
    public function countAll($filters = [])
    {
        $where = [];
        $params = [];

        if (!empty($filters['departamento'])) {
            $where[] = "departamento LIKE :departamento";
            $params[':departamento'] = "%" . $filters['departamento'] . "%";
        }
        if (!empty($filters['provincia'])) {
            $where[] = "provincia LIKE :provincia";
            $params[':provincia'] = "%" . $filters['provincia'] . "%";
        }
        if (!empty($filters['distrito'])) {
            $where[] = "distrito LIKE :distrito";
            $params[':distrito'] = "%" . $filters['distrito'] . "%";
        }

        $whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM municipios $whereSql");

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /* Insertar un nuevo municipio */
    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO municipios (
                anio, ubigeo, departamento, provincia, distrito, tipomuni,
                tipovia, via, numero, codigo, telefono1, telefono2, telefono3,
                telefono4, facebook, correo, pagina, nombre, apellidop, apellidom,
                sexo, telfalcalde, correoalcalde
            ) VALUES (
                :anio, :ubigeo, :departamento, :provincia, :distrito, :tipomuni,
                :tipovia, :via, :numero, :codigo, :telefono1, :telefono2, :telefono3,
                :telefono4, :facebook, :correo, :pagina, :nombre, :apellidop, :apellidom,
                :sexo, :telfalcalde, :correoalcalde
            )
        ");

        return $stmt->execute($data);
    }

        /* 🔍 Buscar municipios por nombre o ubicación (para API) */
        public function buscarPorNombreODistrito($texto)
        {
            $stmt = $this->pdo->prepare("
                SELECT *
                FROM municipios
                WHERE nombre LIKE :texto
                   OR distrito LIKE :texto
                   OR provincia LIKE :texto
                   OR departamento LIKE :texto
                ORDER BY departamento, provincia, distrito
            ");
            $stmt->bindValue(':texto', "%$texto%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
}
