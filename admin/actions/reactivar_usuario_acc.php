<?php
require_once __DIR__ . '/../../functions/autoload.php';

$getData = $_GET;

try {
    // Validación básica
    if (empty($getData['id_usuario'])) {
        throw new Exception("ID de usuario no válido.");
    }

    $id = (int) $getData['id_usuario'];

    // Cargar usuario por id
    $usuario = Usuario::get_x_id($id);
    if (!$usuario) {
        throw new Exception("Usuario no encontrado.");
    }

    // Marcar como activo
    $usuario->reactivar();

    // Alerta de éxito
    Alerta::add_alerta("success", "Usuario reactivado: " . $usuario->getUsuario() . " (ID: " . $id . ")");

} catch (Exception $e) {
    Alerta::add_alerta("danger", "No fue posible reactivar el usuario.");
    Alerta::add_alerta("secondary", $e->getMessage());
}

// Redirección al listado
header('Location: ../index.php?sec=usuarios');
exit;
