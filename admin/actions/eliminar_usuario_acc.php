<?php
require_once __DIR__ . '/../../functions/autoload.php';

$id = $_GET['id'] ?? false;

if (!$id) {
    die("ID de usuario no válido.");
}

try {
    $usuario = Usuario::get_x_id($id_usuario);

    if (!$usuario) {
        die("usuario no encontrado.");
    }

    // Marcamos como inactivo en vez de eliminar físicamente
    $usuario->eliminarUsuario();

    Alerta::add_alerta("danger", "Se eliminó correctamente el usuario: " . $postData['usuario'] . " (ID: " . $postData['id_usuario'] . ")");

} catch (Exception $e) {
    die("No se pudo eliminar el usuario: " . $e->getMessage());
}

header('Location: ../index.php?sec=usuarios');
exit;