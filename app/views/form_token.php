<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Generar Token</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2 class="mb-4">🔑 Generar Token de Acceso</h2>

<form action="index.php?action=storeToken" method="POST" class="card p-4 shadow-sm">
  <div class="mb-3">
    <label class="form-label">Seleccionar Cliente</label>
    <select name="id_cliente" class="form-select" required>
      <option value="">-- Selecciona un cliente --</option>
      <?php foreach ($clientes as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['razon_social']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <button type="submit" class="btn btn-success">Generar Token</button>
  <a href="index.php?action=tokens" class="btn btn-secondary">Volver</a>
</form>

</body>
</html>
