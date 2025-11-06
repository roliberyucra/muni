<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Municipio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Registrar Municipio</h1>
    <div>
        <a href="index.php?action=index" class="btn btn-secondary">← Volver a lista</a>
    </div>
</div>

<?php
// Helper simple para escapar salidas
function esc($v) {
    return isset($v) ? htmlspecialchars($v, ENT_QUOTES, 'UTF-8') : '';
}
?>

<form action="index.php?action=store" method="POST" class="card p-4 shadow-sm">
    <div class="row g-3">

        <div class="col-md-2">
            <label class="form-label">Año</label>
            <input type="number" name="anio" class="form-control" value="<?= esc($_POST['anio'] ?? '') ?>" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Ubigeo</label>
            <input type="text" name="ubigeo" class="form-control" value="<?= esc($_POST['ubigeo'] ?? '') ?>">
        </div>

        <div class="col-md-7">
            <label class="form-label">Departamento</label>
            <input type="text" name="departamento" class="form-control" value="<?= esc($_POST['departamento'] ?? '') ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Provincia</label>
            <input type="text" name="provincia" class="form-control" value="<?= esc($_POST['provincia'] ?? '') ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Distrito</label>
            <input type="text" name="distrito" class="form-control" value="<?= esc($_POST['distrito'] ?? '') ?>" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Tipo Municipio</label>
            <input type="text" name="tipomuni" class="form-control" value="<?= esc($_POST['tipomuni'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Tipo Vía</label>
            <input type="text" name="tipovia" class="form-control" value="<?= esc($_POST['tipovia'] ?? '') ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Vía</label>
            <input type="text" name="via" class="form-control" value="<?= esc($_POST['via'] ?? '') ?>">
        </div>

        <div class="col-md-2">
            <label class="form-label">Número</label>
            <input type="text" name="numero" class="form-control" value="<?= esc($_POST['numero'] ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Código</label>
            <input type="text" name="codigo" class="form-control" value="<?= esc($_POST['codigo'] ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Teléfono 1</label>
            <input type="text" name="telefono1" class="form-control" value="<?= esc($_POST['telefono1'] ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Teléfono 2</label>
            <input type="text" name="telefono2" class="form-control" value="<?= esc($_POST['telefono2'] ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Teléfono 3</label>
            <input type="text" name="telefono3" class="form-control" value="<?= esc($_POST['telefono3'] ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Teléfono 4</label>
            <input type="text" name="telefono4" class="form-control" value="<?= esc($_POST['telefono4'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Facebook</label>
            <input type="text" name="facebook" class="form-control" value="<?= esc($_POST['facebook'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" value="<?= esc($_POST['correo'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Página web</label>
            <input type="text" name="pagina" class="form-control" value="<?= esc($_POST['pagina'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Nombre (Alcalde)</label>
            <input type="text" name="nombre" class="form-control" value="<?= esc($_POST['nombre'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Apellido Paterno</label>
            <input type="text" name="apellidop" class="form-control" value="<?= esc($_POST['apellidop'] ?? '') ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Apellido Materno</label>
            <input type="text" name="apellidom" class="form-control" value="<?= esc($_POST['apellidom'] ?? '') ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Sexo</label>
            <select name="sexo" class="form-select">
                <option value="" <?= (($_POST['sexo'] ?? '') === '') ? 'selected' : '' ?>>--</option>
                <option value="M" <?= (($_POST['sexo'] ?? '') === 'M') ? 'selected' : '' ?>>M</option>
                <option value="F" <?= (($_POST['sexo'] ?? '') === 'F') ? 'selected' : '' ?>>F</option>
                <option value="O" <?= (($_POST['sexo'] ?? '') === 'O') ? 'selected' : '' ?>>Otro</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Tel. Alcalde</label>
            <input type="text" name="telfalcalde" class="form-control" value="<?= esc($_POST['telfalcalde'] ?? '') ?>">
        </div>

        <div class="col-md-5">
            <label class="form-label">Correo Alcalde</label>
            <input type="email" name="correoalcalde" class="form-control" value="<?= esc($_POST['correoalcalde'] ?? '') ?>">
        </div>

    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-success">Guardar Municipio</button>
        <a href="index.php?action=index" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

</body>
</html>
