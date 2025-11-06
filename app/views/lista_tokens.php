<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Tokens</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Tokens Generados</h1>
  <div>
    <a href="index.php?action=createTokenForm" class="btn btn-success me-2">➕ Generar Token</a>
    <a href="index.php?action=clientes" class="btn btn-primary me-2">👥 Clientes</a>
    <a href="index.php?action=index" class="btn btn-secondary me-2">🏠 Municipios</a>
    <a href="index.php?action=logout" class="btn btn-danger">🚪 Cerrar sesión</a>
  </div>
</div>

<table class="table table-bordered">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Cliente</th>
      <th>Token</th>
      <th>Fecha Registro</th>
      <th>Estado</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($tokens): ?>
      <?php foreach ($tokens as $t): ?>
        <tr>
          <td><?= $t['id'] ?></td>
          <td><?= htmlspecialchars($t['razon_social']) ?></td>
          <td><code><?= htmlspecialchars($t['token']) ?></code></td>
          <td><?= htmlspecialchars($t['fecha_registro']) ?></td>
          <td><?= $t['estado'] ? 'Activo' : 'Inactivo' ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="5" class="text-center">No hay tokens registrados</td></tr>
    <?php endif; ?>
  </tbody>
</table>

</body>
</html>
