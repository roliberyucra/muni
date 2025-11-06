<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Municipios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Municipios</h1>
    <div>
        <a href="index.php?action=createForm" class="btn btn-success me-2">Agregar Nuevo Municipio</a>
        <a href="index.php?action=clienteApi" class="btn btn-info me-2">Consulta API</a>
        <a href="index.php?action=clientes" class="btn btn-primary me-2">Clientes API</a>
        <a href="index.php?action=tokens" class="btn btn-warning me-2">Ver Tokens</a>
        <a href="index.php?action=logout" class="btn btn-danger">Cerrar sesión</a>
    </div>
</div>

<!-- Filtros -->
<form method="GET" class="mb-3 row g-2 align-items-end">
    <input type="hidden" name="action" value="index">

    <div class="col">
        <label class="form-label">Departamento</label>
        <input type="text" name="departamento" value="<?= htmlspecialchars($_GET['departamento'] ?? '') ?>" class="form-control">
    </div>

    <div class="col">
        <label class="form-label">Provincia</label>
        <input type="text" name="provincia" value="<?= htmlspecialchars($_GET['provincia'] ?? '') ?>" class="form-control">
    </div>

    <div class="col">
        <label class="form-label">Distrito</label>
        <input type="text" name="distrito" value="<?= htmlspecialchars($_GET['distrito'] ?? '') ?>" class="form-control">
    </div>

    <div class="col-auto">
        <label class="form-label">Mostrar</label>
        <select name="limit" class="form-select" onchange="this.form.submit()">
            <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
            <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
            <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
        </select>
    </div>

    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="index.php?action=index" class="btn btn-secondary">Limpiar</a>
    </div>
</form>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Año</th>
            <th>Departamento</th>
            <th>Provincia</th>
            <th>Distrito</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($municipios): ?>
            <?php foreach ($municipios as $m): ?>
                <tr>
                    <td><?= $m['id'] ?></td>
                    <td><?= htmlspecialchars($m['anio']) ?></td>
                    <td><?= htmlspecialchars($m['departamento']) ?></td>
                    <td><?= htmlspecialchars($m['provincia']) ?></td>
                    <td><?= htmlspecialchars($m['distrito']) ?></td>
                    <td><a href="#" class="btn btn-sm btn-outline-dark">Ver más</a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No se encontraron resultados</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Paginación -->
<nav>
  <ul class="pagination">
    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
      <a class="page-link" href="index.php?action=index&page=<?= $page-1 ?>&limit=<?= $limit ?>">Anterior</a>
    </li>
    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
      <a class="page-link" href="index.php?action=index&page=<?= $page+1 ?>&limit=<?= $limit ?>">Siguiente</a>
    </li>
  </ul>
</nav>

</body>
</html>
