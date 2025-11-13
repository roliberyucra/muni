<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Tokens</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold text-primary">🔐 Tokens Generados</h1>
    <div>
      <a href="index.php?action=createTokenForm" class="btn btn-success me-2">➕ Generar Token</a>
      <a href="index.php?action=clientes" class="btn btn-primary me-2">👥 Clientes</a>
      <a href="index.php?action=index" class="btn btn-secondary me-2">🏠 Municipios</a>
      <a href="index.php?action=logout" class="btn btn-danger">🚪 Cerrar sesión</a>
    </div>
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-body p-0">
      <table class="table table-striped align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Token</th>
            <th>Fecha Registro</th>
            <th>Estado</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($tokens): ?>
            <?php foreach ($tokens as $t): ?>
              <tr>
                <td><?= $t['id'] ?></td>
                <td><?= htmlspecialchars($t['razon_social']) ?></td>
                <td><code class="text-break"><?= htmlspecialchars($t['token']) ?></code></td>
                <td><?= htmlspecialchars($t['fecha_registro']) ?></td>
                <td>
                  <?php if ($t['estado']): ?>
                    <span class="badge bg-success">Activo</span>
                  <?php else: ?>
                    <span class="badge bg-danger">Inactivo</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <a href="index.php?action=editToken&id=<?= $t['id'] ?>" class="btn btn-warning btn-sm">
                    ✏️ Editar
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center text-muted py-3">
                No hay tokens registrados actualmente.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
