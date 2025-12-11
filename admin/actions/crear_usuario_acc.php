<?php
require_once __DIR__ . '/../../functions/autoload.php';

Autenticacion::verify(true);

// Validar datos mínimos
$usuario = $_POST['usuario'] ?? '';
$email   = $_POST['email'] ?? '';
$clave   = $_POST['clave'] ?? '';
$rol     = $_POST['rol'] ?? '';

if (empty($usuario) || empty($email) || empty($clave) || empty($rol)) {
    Alerta::add_alerta('danger', 'Todos los campos son obligatorios');
    header("Location: ../?sec=crear_usuario");
    exit;
}

// 🔐 **HASH REAL DE LA CLAVE**
$clave_hashed = password_hash($clave, PASSWORD_DEFAULT);

// Crear usuario en la tabla `usuarios`
try {
    $db = (new Conexion())->getConexion();

    $stmt = $db->prepare("
        INSERT INTO usuarios (usuario, email, clave, activo)
        VALUES (:usuario, :email, :clave, 1)
    ");
    $stmt->execute([
        ':usuario' => $usuario,
        ':email'   => $email,
        ':clave'   => $clave_hashed
    ]);

    // Obtener ID recién creado
    $id_usuario = $db->lastInsertId();

    // Asignar rol en tabla pivote usuario_rol
    $stmt2 = $db->prepare("
        INSERT INTO usuario_rol (id_usuario, id_rol)
        VALUES (:id_usuario, :id_rol)
    ");
    $stmt2->execute([
        ':id_usuario' => $id_usuario,
        ':id_rol'     => $rol
    ]);

    Alerta::add_alerta('success', 'Usuario creado correctamente');
    header("Location: ../?sec=usuarios");
    exit;

} catch (Exception $e) {
    Alerta::add_alerta('danger', 'Error al crear usuario: ' . $e->getMessage());
    header("Location: ../?sec=crear_usuario");
    exit;
}
