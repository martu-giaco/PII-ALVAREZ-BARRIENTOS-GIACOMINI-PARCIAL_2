<?php
require_once __DIR__ . '/../../functions/autoload.php';

// Autenticación
Autenticacion::verify(true);

$usuarios = Usuario::obtenerUsuariosConInactivos(); // Obtener todos los usuarios
$usuarioActualId = $_SESSION['loggedIn']['id_usuario'] ?? null; // ID del usuario logueado

// Separar usuarios por rol
$admins = [];
$clientes = [];

foreach ($usuarios as $usuario) {
    if (mb_strtolower(trim($usuario->getRol())) === 'admin') {
        $admins[] = $usuario;
    } else {
        $clientes[] = $usuario;
    }
}
?>

<h2 class="mb-3">Usuarios</h2>
<?= Alerta::get_alertas(); ?>

<!-- Tabla de Admins -->
<?php if ($admins): ?>
<h4 class="mt-4">Administradores</h4>
<table class="table table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Usuario</th>
    <th>Email</th>
    <th>Clave</th>
    <th>Rol</th>
    <th>Opciones</th>
</tr>
</thead>
<tbody>
<?php foreach ($admins as $usuario):
    $activo = $usuario->activo ?? 1;
    $esUsuarioActual = $usuario->getIdUsuario() === $usuarioActualId;
    ?>
    <tr>
        <td><?= htmlspecialchars($usuario->getIdUsuario()); ?></td>
        <td><?= htmlspecialchars($usuario->getUsuario()); ?></td>
        <td><?= htmlspecialchars($usuario->getEmail()); ?></td>
        <td><?= htmlspecialchars($usuario->getClave()); ?></td>
        <td><?= htmlspecialchars($usuario->getRol()); ?></td>
        <td>
            <?php if ($activo): ?>
                <?php if (!$esUsuarioActual): ?>
                    <a href="?sec=editar_usuario&id=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-edit"></i> Editar</a>
                    <a href="?sec=desactivar_usuario&id=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-warning text-white py-2 px-3"><i class="fa-solid fa-moon"></i> Desactivar</a>
                    <a href="?sec=eliminar_usuario&id=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-danger text-white py-2 px-3"><i class="fas fa-trash-alt"></i> Eliminar</a>
                <?php else: ?>
                    <span class="text-muted">Usuario actual. Acciones no disponibles</span>
                <?php endif; ?>
            <?php else: ?>
                <a href="actions/reactivar_usuario_acc.php?id_usuario=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-redo-alt"></i> Reactivar</a>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>

<!-- Tabla de Clientes -->
<?php if ($clientes): ?>
<h4 class="mt-5">Clientes</h4>
<table class="table table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Usuario</th>
    <th>Email</th>
    <th>Clave</th>
    <th>Rol</th>
    <th>Opciones</th>
</tr>
</thead>
<tbody>
<?php foreach ($clientes as $usuario):
    $activo = $usuario->activo ?? 1;
    $esUsuarioActual = $usuario->getIdUsuario() === $usuarioActualId;
    ?>
    <tr>
        <td><?= htmlspecialchars($usuario->getIdUsuario()); ?></td>
        <td><?= htmlspecialchars($usuario->getUsuario()); ?></td>
        <td><?= htmlspecialchars($usuario->getEmail()); ?></td>
        <td><?= htmlspecialchars($usuario->getClave()); ?></td>
        <td><?= htmlspecialchars($usuario->getRol()); ?></td>
        <td>
            <?php if ($activo): ?>
                <?php if (!$esUsuarioActual): ?>
                    <a href="?sec=editar_usuario&id=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-edit"></i> Editar</a>
                    <a href="?sec=desactivar_usuario&id=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-warning text-white py-2 px-3"><i class="fa-solid fa-moon"></i> Desactivar</a>
                    <a href="?sec=eliminar_usuario&id=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-danger text-white py-2 px-3"><i class="fas fa-trash-alt"></i> Eliminar</a>
                <?php else: ?>
                    <span class="text-muted">Usuario actual. Acciones no disponibles</span>
                <?php endif; ?>
            <?php else: ?>
                <a href="actions/reactivar_usuario_acc.php?id_usuario=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-redo-alt"></i> Reactivar</a>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>

<a href="?sec=crear_usuario" class="btn btn-primary text-white py-3 px-5">Crear nuevo usuario</a>
