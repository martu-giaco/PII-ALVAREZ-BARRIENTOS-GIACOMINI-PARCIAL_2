<?php
require_once __DIR__ . '/../../functions/autoload.php';

$getData = $_GET;

try {
    // Validación básica
    if (empty($getData['id'])) {
        throw new Exception("ID de usuario no válido.");
    }

    $id = (int) $getData['id'];

    // Cargar usuario por id
    $usuario = Usuario::get_x_id($id);
    if (!$usuario) {
        throw new Exception("Usuario no encontrado.");
    }

    // Marcar como inactivo
    $usuario->desactivar();

    // Alerta de éxito
    Alerta::add_alerta("warning", "Se desactivó correctamente el usuario: " . $usuario->getUsuario() . " (ID: " . $id . ")");

} catch (Exception $e) {
    Alerta::add_alerta("danger", "No se pudo desactivar el usuario.");
    Alerta::add_alerta("secondary", $e->getMessage());
}

// Redirección al listado
header('Location: ../index.php?sec=usuarios');
exit;
