<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Token</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h3 class="mb-4 text-primary">✏️ Editar Token</h3>

<form action="index.php?action=updateToken" method="POST" class="card p-4 shadow-sm">
    <input type="hidden" name="id" value="<?= $token['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Token</label>
        <input type="text" name="token" class="form-control" value="<?= htmlspecialchars($token['token']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="1" <?= $token['estado']==1 ? 'selected' : '' ?>>Activo</option>
            <option value="0" <?= $token['estado']==0 ? 'selected' : '' ?>>Inactivo</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Expiración</label>
        <input type="datetime-local" name="expiracion" class="form-control" 
            value="<?= date('Y-m-d\TH:i', strtotime($token['expiracion'])) ?>">
    </div>

    <button type="submit" class="btn btn-success w-100">💾 Guardar Cambios</button>
</form>

<a href="index.php?action=tokens" class="btn btn-secondary mt-3">⬅ Volver</a>

</body>
</html>
