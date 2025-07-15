<?php
session_start(); // Iniciamos la sesión para usar $_SESSION
require_once __DIR__ . '/../../functions/autoload.php';

// Incluye clases como Usuario, Alerta, etc.

// Captura de datos del formulario
$usuarioInput = $_POST['usuario'] ?? '';
$claveInput = $_POST['clave'] ?? '';

$usuario = Usuario::obtenerPorUsuarioEmail($usuarioInput);

if (!$usuario) {
    Alerta::add_alerta('danger', 'El usuario no existe.');
    header("Location: ../index.php?sec=login");
    exit;
}

// Verificamos contraseña (hash o texto plano si estás en pruebas)
$claveGuardada = $usuario->getClave();

if (password_verify($claveInput, $claveGuardada) || $claveInput === $claveGuardada) {

    // Guardamos sesión del login
    $_SESSION['loggedIn'] = [
        'id_usuario' => $usuario->getIdUsuario(),
        'usuario'    => $usuario->getUsuario(),
        'email'      => $usuario->getEmail(),
        'rol'        => $usuario->getRol() // Puede ser 'admin' o 'cliente'
    ];

    // Redirección según rol
    if ($usuario->getUsuario() === 'pepe') {
        header("Location: ../index.php?sec=inicio"); // Vista admin
    } else {
        header("Location: ../../index.php"); // Vista cliente
    }
    exit;

} else {
    Alerta::add_alerta('warning', 'La clave ingresada no es correcta.');
    header("Location: ../index.php?sec=login");
    exit;
}
