<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);
    }

    /* Mostrar formulario de login */
    public function loginForm()
    {
        include __DIR__ . '/../views/login.php';
    }

    /* Iniciar sesión */
    public function login($data)
{
    // Verificar que se enviaron los datos
    if (!isset($data['email']) || !isset($data['password'])) {
        $error = "Por favor ingresa tu correo y contraseña.";
        include __DIR__ . '/../views/login.php';
        return;
    }

    $email = trim($data['email']);
    $password = trim($data['password']);

    // Validar campos vacíos
    if ($email === '' || $password === '') {
        $error = "Por favor completa ambos campos.";
        include __DIR__ . '/../views/login.php';
        return;
    }

    // Buscar usuario por correo
    $user = $this->userModel->findByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id'     => $user['id'],
            'email'  => $user['email'],
            'nombre' => $user['nombre']
        ];
        header("Location: index.php?action=index");
        exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
        include __DIR__ . '/../views/login.php';
    }
}


    /* Cerrar sesión */
    public function logout()
    {
        session_destroy();
        header("Location: index.php?action=loginForm");
        exit;
    }

    /* Formulario de registro */
    public function registerForm()
    {
        include __DIR__ . '/../views/register.php';
    }

    /* Registrar usuario */
    public function register($data)
    {
        // Validar campos obligatorios
        if (empty($data['email']) || empty($data['password']) || empty($data['confirm_password'])) {
            $error = "Todos los campos son obligatorios.";
            include __DIR__ . '/../views/register.php';
            return;
        }

        // Validar contraseñas iguales
        if ($data['password'] !== $data['confirm_password']) {
            $error = "Las contraseñas no coinciden.";
            include __DIR__ . '/../views/register.php';
            return;
        }

        // Encriptar contraseña
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // Crear usuario
        $this->userModel->create([
            'email'    => $data['email'],
            'password' => $hashedPassword,
            'nombre'   => $data['nombre'] ?? 'Usuario'
        ]);

        $success = "Usuario registrado correctamente. Ahora puedes iniciar sesión.";
        include __DIR__ . '/../views/login.php';
    }
}
