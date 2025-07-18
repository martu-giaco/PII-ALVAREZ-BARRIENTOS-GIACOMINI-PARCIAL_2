<?php
require_once __DIR__ . '/../../functions/autoload.php';

Autenticacion::verify(true); // verifica admin

$id = $_GET['id'] ?? false;

if (!$id) {
    die("ID de producto no válido.");
}

$producto = Producto::get_x_id($id);

if (!$producto) {
    die("Producto no encontrado.");
}
?>

<h2>¿Estás seguro de que deseas desactivar este producto?</h2>

<div class="card my-4">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($producto->getNombre()); ?></h5>
        <p class="card-text"><?= htmlspecialchars($producto->getDescripcion()); ?></p>
        <p><strong>Precio:</strong> $<?= number_format($producto->getPrecio(), 2, ',', '.'); ?></p>
        <img src="../assets/imagenes/prods/<?= $producto->getImagen(); ?>" alt="Imagen del producto" width="300" style="object-fit: contain;">
    </div>
</div>

<form action="actions/desactivar_producto_acc.php" method="get">
    <input type="hidden" name="id" value="<?= htmlspecialchars($producto->getId()); ?>">
    <button type="submit" class="btn btn-warning py-3 px-5">desactivar</button>
    <a href="?sec=productos" class="btn btn-light py-3 px-5">Cancelar</a>
</form>
