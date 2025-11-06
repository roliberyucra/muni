<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar sesión</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card p-4 shadow rounded" style="width: 25rem;">
  <h3 class="text-center mb-3">🔐 Iniciar sesión</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php elseif (!empty($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="POST" action="index.php?action=login" novalidate>
    <!-- Campo de correo -->
    <div class="mb-3">
      <label for="email" class="form-label">Correo electrónico</label>
      <input 
        type="email" 
        name="email" 
        id="email" 
        class="form-control" 
        placeholder="ejemplo@correo.com"
        required 
        autofocus>
    </div>

    <!-- Campo de contraseña -->
    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input 
        type="password" 
        name="password" 
        id="password" 
        class="form-control" 
        placeholder="Tu contraseña"
        required>
    </div>

    <!-- Botón de acceso -->
    <button type="submit" class="btn btn-primary w-100 mb-2">Ingresar</button>

    <!-- Link al registro -->
    <a href="index.php?action=registerForm" class="btn btn-link w-100">¿No tienes cuenta? Regístrate aquí</a>
  </form>
</div>

</body>
</html>
