<?php
require_once __DIR__ . '/../../functions/autoload.php';

// Lectura directa del formulario
$emailOrUser = $_POST['usuario'] ?? '';
$password     = $_POST['clave'] ?? '';

if (trim($emailOrUser) === '' || $password === '') {
    Alerta::add_alerta('danger', 'Usuario y clave son obligatorios.');
    header('Location: ../index.php?sec=login');
    exit;
}

// Intentar iniciar sesión con la clase Autenticacion
$result = Autenticacion::log_in($emailOrUser, $password);

// Si Autenticacion::log_in devolvió false/null, ya añadió alertas; redirigir al login
if ($result === false || $result === null) {
    header('Location: ../index.php?sec=login');
    exit;
}

// A partir de aquí, se espera que la sesión esté creada por Autenticacion::log_in
if (session_status() === PHP_SESSION_NONE) session_start();

// Obtiene rol desde sesión si existe
$rolSesion = $_SESSION['loggedIn']['rol'] ?? null;

// Si no está en sesión, consultar la BD directamente (robusto)
if (empty($rolSesion)) {
    // Intentar obtener el usuario por email o usuario
    $usuarioObj = Usuario::obtenerPorUsuarioEmail($emailOrUser);

    if (!$usuarioObj) {
        Alerta::add_alerta('danger', 'Error interno: no se pudo recuperar el usuario tras autenticarlo.');
        header('Location: ../index.php?sec=login');
        exit;
    }

    $rol = $usuarioObj->getRol();
} else {
    $rol = $rolSesion;
}

// Normalizar rol: quitar espacios y pasar a minúsculas para comparación fiable
$rol_normalizado = mb_strtolower(trim($rol));

// (Opcional) agregar alerta de debug temporal si querés ver qué rol se detectó
// Alerta::add_alerta('secondary', 'Rol detectado: ' . $rol_normalizado);

Alerta::add_alerta('success', 'Sesión iniciada correctamente. Bienvenido ' . htmlspecialchars($_SESSION['loggedIn']['usuario'] ?? $emailOrUser) . '.');

// Redirigir según rol (solo admin va al panel admin)
if ($rol_normalizado === 'admin') {
    header('Location: ../index.php?sec=usuarios'); // panel admin: ajustar si tu ruta es distinta
    exit;
}

// Si no es admin, redirigir al front (cliente)
// Ajustar la ruta pública según tu proyecto
header('Location: ../../index.php');
exit;
