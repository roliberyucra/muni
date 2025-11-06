<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Cliente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2 class="mb-4">➕ Registrar Cliente API</h2>

<form action="index.php?action=clienteStore" method="POST" class="card p-4 shadow-sm">
  <div class="mb-3">
    <label class="form-label">RUC</label>
    <input type="number" name="ruc" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Razón Social</label>
    <input type="text" name="razon_social" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Teléfono</label>
    <input type="text" name="telefono" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Correo</label>
    <input type="email" name="correo" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Estado</label>
    <select name="estado" class="form-select">
      <option value="1">Activo</option>
      <option value="0">Inactivo</option>
    </select>
  </div>

  <button type="submit" class="btn btn-success">Registrar</button>
  <a href="index.php?action=clientes" class="btn btn-secondary">Volver</a>
</form>

</body>
</html>
