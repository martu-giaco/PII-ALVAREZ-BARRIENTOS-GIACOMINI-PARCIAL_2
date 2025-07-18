<?php
require_once __DIR__ . '/../../functions/autoload.php';

// descomentar para hacer autenticacion
Autenticacion::verify(true);


$usuarios = Usuario::obtenerUsuariosConInactivos(); // Método que debes agregar

?>

<h2 class="mb-3">Usuarios</h2>
<?= Alerta::get_alertas(); ?>

<table class="table table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Usuario</th>
    <th>Email</th>
    <th>Clave</th>
    <th>Permisos</th>
    <th>Opciones</th>
</tr>
</thead>
<tbody>
<?php foreach ($usuarios as $usuario) { 
    $activo = $usuario->activo ?? 1;;
    ?>
    <tr>
        <td><?= htmlspecialchars($usuario->getIdUsuario()); ?></td>
        <td><?= htmlspecialchars($usuario->getUsuario()); ?></td>
        <td><?= htmlspecialchars($usuario->getEmail()); ?></td>
        <td><?= htmlspecialchars($usuario->getClave()); ?></td>
        <td><?= htmlspecialchars($usuario->getRol()); ?></td>
        <td>
            <?php if ($activo): ?>
                <a href="?sec=editar_usuario&id=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-edit"></i> Editar</a>
                <a href="?sec=desactivar_usuario&id=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-warning text-white py-2 px-3"><i class="fa-solid fa-moon"></i> Desactivar</a>
                <a href="?sec=eliminar_usuario&id=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-danger text-white py-2 px-3"><i class="fas fa-trash-alt"></i> Eliminar</a>
            <?php else: ?>
                <a href="actions/reactivar_usuario_acc.php?id_usuario=<?= urlencode($usuario->getIdUsuario()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-redo-alt"></i> Reactivar</a>
            <?php endif; ?>
        </td>
    </tr> 
    <?php   
}
?>
</tbody>
</table>

<a href="?sec=crear_usuario" class="btn btn-primary text-white py-3 px-5">Crear nuevo usuario</a>
