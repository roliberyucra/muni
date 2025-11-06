<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clientes API</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Clientes API</h1>
  <div>
    <a href="index.php?action=clienteCreateForm" class="btn btn-success me-2">➕ Nuevo Cliente</a>
    <a href="index.php?action=tokens" class="btn btn-warning me-2">🔑 Tokens</a>
    <a href="index.php?action=index" class="btn btn-secondary me-2">🏠 Municipios</a>
    <a href="index.php?action=logout" class="btn btn-danger">🚪 Cerrar sesión</a>
  </div>
</div>

<table class="table table-bordered">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>RUC</th>
      <th>Razón Social</th>
      <th>Teléfono</th>
      <th>Correo</th>
      <th>Fecha Registro</th>
      <th>Estado</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($clientes): ?>
      <?php foreach ($clientes as $c): ?>
        <tr>
          <td><?= $c['id'] ?></td>
          <td><?= htmlspecialchars($c['ruc']) ?></td>
          <td><?= htmlspecialchars($c['razon_social']) ?></td>
          <td><?= htmlspecialchars($c['telefono']) ?></td>
          <td><?= htmlspecialchars($c['correo']) ?></td>
          <td><?= htmlspecialchars($c['fecha_registro']) ?></td>
          <td><?= $c['estado'] ? 'Activo' : 'Inactivo' ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="7" class="text-center">No hay clientes registrados</td></tr>
    <?php endif; ?>
  </tbody>
</table>

</body>
</html>
