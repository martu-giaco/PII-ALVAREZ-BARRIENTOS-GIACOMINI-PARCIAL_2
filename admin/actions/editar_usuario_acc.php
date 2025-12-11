<?php
// Usar ruta absoluta del archivo actual
require_once __DIR__ . '/../../functions/autoload.php';

Autenticacion::verify(true);

// Base relativa al panel admin
$admin_base = dirname(dirname($_SERVER['PHP_SELF'])); // /admin

$id_usuario = $_POST['id_usuario'] ?? null;
$usuario_nuevo = trim($_POST['usuario'] ?? '');
$email_nuevo = trim($_POST['email'] ?? '');
$clave_nueva = $_POST['clave'] ?? '';
$rol_nuevo = $_POST['rol'] ?? null;

if (!$id_usuario) die("ID de usuario no proporcionado.");

$usuario = Usuario::get_x_id((int)$id_usuario);
if (!$usuario) die("Usuario no encontrado.");

// Actualizar datos (clave opcional)
$exito = $usuario->update($usuario_nuevo, $email_nuevo, $clave_nueva);

if ($exito && $rol_nuevo) {
    try {
        $db = (new Conexion())->getConexion();

        // Borrar rol anterior
        $stmt = $db->prepare("DELETE FROM usuario_rol WHERE id_usuario = ?");
        $stmt->execute([$usuario->getIdUsuario()]);

        // Asignar nuevo rol
        $stmt2 = $db->prepare("INSERT INTO usuario_rol (id_usuario, id_rol) VALUES (?, ?)");
        $stmt2->execute([$usuario->getIdUsuario(), $rol_nuevo]);
    } catch (Exception $e) {
        Alerta::add_alerta('warning', 'Usuario editado, pero no se pudo actualizar el rol: ' . $e->getMessage());
        header("Location: {$admin_base}/?sec=usuarios");
        exit;
    }
}

Alerta::add_alerta('success', 'Usuario editado correctamente: ' . htmlspecialchars($usuario->getUsuario()) . ' (ID: ' . $usuario->getIdUsuario() . ')');

// Redirigir al panel admin
header("Location: {$admin_base}/?sec=usuarios");
exit;
