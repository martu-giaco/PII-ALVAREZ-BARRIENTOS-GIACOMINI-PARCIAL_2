<?php
require_once __DIR__ . '/../../functions/autoload.php';

$postData = $_POST;

try {
    // Validaciones básicas
    if (empty($postData['id_usuario']) || empty($postData['usuario']) || empty($postData['email']) || empty($postData['clave'])) {
        throw new Exception("Faltan datos obligatorios.");
    }

    $id = (int) $postData['id_usuario'];

    // Cargar usuario por id
    $usuario = Usuario::get_x_id($id);
    if (!$usuario) {
        throw new Exception("Usuario no encontrado.");
    }

    // Actualizar usuario
    $usuario->update(
        trim($postData['usuario']),
        trim($postData['email']),
        trim($postData['clave'])
    );

    // Alerta de éxito
    Alerta::add_alerta("success", "Usuario editado correctamente: " . $postData['usuario'] . " (ID: " . $id . ")");

    // Redirección al listado
    header('Location: ../index.php?sec=usuarios');
    exit;

} catch (Exception $e) {
    Alerta::add_alerta("danger", "No se pudo editar el usuario.");
    Alerta::add_alerta("secondary", $e->getMessage());

    // Volver al formulario de edición
    $id_return = isset($postData['id_usuario']) ? (int)$postData['id_usuario'] : '';
    header('Location: ../index.php?sec=editar_usuario&id=' . urlencode((string)$id_return));
    exit;
}
