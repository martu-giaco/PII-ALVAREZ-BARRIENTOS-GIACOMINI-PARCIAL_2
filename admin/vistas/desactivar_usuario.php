<?php
require_once __DIR__ . '/../../functions/autoload.php';

Autenticacion::verify(true); // verifica admin

$id_usuario = $_GET['id'] ?? false;

if (!$id_usuario) {
    die("ID de usuario no válido.");
}

$usuario = Usuario::get_x_id($id_usuario);

if (!$usuario) {
    die("Usuario no encontrado.");
}
?>

<h2>¿Estás seguro de que deseas desactivar este usuario?</h2>

<div class="card my-4">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($usuario->getUsuario()); ?></h5>
    </div>
</div>

<form action="actions/desactivar_usuario_acc.php" method="get">
    <input type="hidden" name="id" value="<?= htmlspecialchars($usuario->getIdUsuario()); ?>">
    <button type="submit" class="btn btn-warning py-3 px-5">desactivar</button>
    <a href="?sec=usuarios" class="btn btn-light py-3 px-5">Cancelar</a>
</form>