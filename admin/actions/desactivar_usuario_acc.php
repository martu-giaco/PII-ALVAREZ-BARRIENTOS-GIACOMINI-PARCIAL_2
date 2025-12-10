<?php
require_once __DIR__ . '/../../functions/autoload.php';

$id_usuario = $_GET['id'] ?? false;

if (!$id_usuario) {
    die("ID de usuario no válido.");
}

try {
    $usuario = Usuario::get_x_id($id_usuario);

    if (!$usuario) {
        die("Usuario no encontrado.");
    }

    // Marcamos como inactivo en vez de eliminar físicamente
    $usuario->marcarComoInactivo();

    Alerta::add_alerta("warning", "Se desactivó correctamente el usuario: " . $postData['usuario'] . " (ID: " . $postData['id_usuario'] . ")");

} catch (Exception $e) {
    die("No se pudo desactivar el usuario: " . $e->getMessage());
}

header('Location: ../index.php?sec=usuarios');
exit;