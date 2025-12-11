<?php
require_once __DIR__ . '/../../functions/autoload.php';

Autenticacion::verify(true);

$getData = $_GET;

try {
    if (empty($getData['id'])) {
        throw new Exception("ID de usuario no válido.");
    }

    $id = (int) $getData['id'];

    $usuario = Usuario::get_x_id($id);
    if (!$usuario) {
        throw new Exception("Usuario no encontrado.");
    }

    // Conectar y ejecutar dentro de transacción para mantener consistencia
    $db = (new Conexion())->getConexion();
    $db->beginTransaction();

    // 1) Borrar filas en tabla pivote usuario_rol
    $stmt = $db->prepare("DELETE FROM usuario_rol WHERE id_usuario = :id_usuario");
    $stmt->execute([':id_usuario' => $id]);

    // 2) Borrar el usuario
    $stmt2 = $db->prepare("DELETE FROM usuarios WHERE id_usuario = :id_usuario");
    $stmt2->execute([':id_usuario' => $id]);

    $db->commit();

    Alerta::add_alerta('success', 'Usuario eliminado: ' . htmlspecialchars($usuario->getUsuario()) . ' (ID: ' . $usuario->getIdUsuario() . ').');
} catch (Exception $e) {
    // Si ocurrió algo en la transacción, intentar rollback si existe conexión
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }

    Alerta::add_alerta('danger', 'No fue posible eliminar el usuario.');
    Alerta::add_alerta('secondary', $e->getMessage());
}

header('Location: ../index.php?sec=usuarios');
exit;
