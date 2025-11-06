<?php
// app/views/cliente_api_view.php
// $respuesta puede venir del controlador (procesarSolicitud)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Cliente API - Consulta Municipios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Cliente API - Consulta de Municipios</h1>
        <a href="index.php?action=index" class="btn btn-secondary">← Volver</a>
    </div>

    <div class="card p-3 mb-4">
        <form method="POST" action="index.php?action=clienteApiRequest">
            <div class="mb-3">
                <input type="hidden" class="form-control" name="token" value="87e66c6d69e6ef4ac4fb-20251002-2" placeholder="Ingrese su token" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tipo de solicitud</label>
                <select name="tipo" class="form-select" required>
                    <option value="verMunicipioByNombre" <?= (($_POST['tipo'] ?? '') === 'verMunicipioByNombre') ? 'selected' : '' ?>>Ver Municipio por Nombre</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Texto a buscar</label>
                <input type="text" class="form-control" name="texto" value="<?= htmlspecialchars($_POST['texto'] ?? '') ?>" placeholder="Lima" required>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <?php if (isset($respuesta)): ?>
        <div class="card p-3">
            <h5>Respuesta de la API</h5>

            <?php if (isset($respuesta['status']) && $respuesta['status']): ?>
                <div class="alert alert-success">Consulta exitosa. Resultados: <?= count($respuesta['contenido'] ?? []) ?></div>

                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Departamento</th>
                            <th>Provincia</th>
                            <th>Distrito</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($respuesta['contenido'] ?? [] as $m): ?>
                            <tr>
                                <td><?= htmlspecialchars($m['id'] ?? '') ?></td>
                                <td><?= htmlspecialchars($m['departamento'] ?? '') ?></td>
                                <td><?= htmlspecialchars($m['provincia'] ?? '') ?></td>
                                <td><?= htmlspecialchars($m['distrito'] ?? '') ?></td>
                                <td><?= htmlspecialchars($m['nombre'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <div class="alert alert-danger">
                    <strong>Error:</strong> <?= htmlspecialchars($respuesta['msg'] ?? 'Sin mensaje') ?>
                    <?php if (!empty($respuesta['raw'])): ?>
                        <pre><?= htmlspecialchars($respuesta['raw']) ?></pre>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>
