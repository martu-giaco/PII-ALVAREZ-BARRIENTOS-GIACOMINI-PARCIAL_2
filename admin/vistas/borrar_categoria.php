<?php
require_once __DIR__ . '/../../functions/autoload.php';

Autenticacion::verify(true); // verifica admin

$id = $_GET['id'] ?? false;

if (!$id) {
    die("ID de categoría no válido.");
}

$categoria = Categoria::get_x_id($id);

if (!$categoria) {
    die("Categoría no encontrada.");
}
?>

<h2>¿Estás seguro de que deseas eliminar esta categoría?</h2>

<div class="card my-4">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($categoria->getNombreCategoria()); ?></h5>
    </div>
</div>

<form action="actions/borrar_categoria_acc.php" method="get">
    <input type="hidden" name="id" value="<?= htmlspecialchars($categoria->getIdCategoria()); ?>">
    <button type="submit" class="btn btn-danger py-3 px-5">Borrar</button>
    <a href="?sec=categorias" class="btn btn-light py-3 px-5">Cancelar</a>
</form>
