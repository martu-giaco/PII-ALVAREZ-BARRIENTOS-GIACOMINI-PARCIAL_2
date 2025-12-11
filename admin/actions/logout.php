<?php
// Cargar autoload para clases y funciones
require_once __DIR__ . '/../../functions/autoload.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) session_start();

// Solo procesar si es POST (confirmación de logout)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Limpiar cualquier alerta pendiente para que no aparezca en login
    if (isset($_SESSION['alertas'])) {
        unset($_SESSION['alertas']);
    }

    // Destruir sesión completamente
    session_unset();
    session_destroy();

    // Redirigir al login
    header("Location: ../../index.php?sec=login");
    exit;
}

// Si se accede directamente sin POST, redirigir al inicio
header("Location: ../../index.php");
exit;
