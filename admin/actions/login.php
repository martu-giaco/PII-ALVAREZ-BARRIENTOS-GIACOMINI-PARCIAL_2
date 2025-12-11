<?php
require_once __DIR__ . '/../../functions/autoload.php';

// Lectura directa del formulario
$emailOrUser = $_POST['usuario'] ?? '';
$password     = $_POST['clave'] ?? '';

// Validación básica
if (trim($emailOrUser) === '' || $password === '') {
    Alerta::add_alerta('danger', 'Usuario y clave son obligatorios.');
    header('Location: ../../index.php?sec=login'); // login general
    exit;
}

// Intentar iniciar sesión
$result = Autenticacion::log_in($emailOrUser, $password);

// Si falló autenticación
if ($result === false || $result === null) {
    header('Location: ../../index.php?sec=login'); // login general
    exit;
}

// Sesión ya creada
if (session_status() === PHP_SESSION_NONE) session_start();

// Obtener rol
$rol = $_SESSION['loggedIn']['rol'] ?? null;

// Si no está definido, consultar DB
if (empty($rol)) {
    $usuarioObj = Usuario::obtenerPorUsuarioEmail($emailOrUser);
    if (!$usuarioObj) {
        Alerta::add_alerta('danger', 'Error interno: no se pudo recuperar el usuario tras autenticarlo.');
        header('Location: ../../index.php?sec=login'); // login general
        exit;
    }
    $rol = $usuarioObj->getRol();
}

$rol_normalizado = mb_strtolower(trim($rol));

// Alerta bienvenida
Alerta::add_alerta('success', 'Sesión iniciada correctamente. Bienvenido ' . htmlspecialchars($_SESSION['loggedIn']['usuario'] ?? $emailOrUser) . '.');

// Redirigir según rol
if ($rol_normalizado === 'admin') {
    // Redirigir al panel admin
    header('Location: ../index.php?sec=inicio'); 
    exit;
}

// Usuario común: redirigir al front
header('Location: ../../index.php'); 
exit;
