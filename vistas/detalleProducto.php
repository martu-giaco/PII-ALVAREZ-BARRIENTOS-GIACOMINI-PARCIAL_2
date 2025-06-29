<?php
require_once __DIR__ . '/../classes/Conexion.php';
require_once __DIR__ . '/../classes/Producto.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='container my-5'><h2>Producto no especificado.</h2></div>";
    return;
}

$producto = Producto::get_x_id((int) $id);

if (!$producto) {
    echo "<div class='container my-5'><h2>Producto no disponible.</h2></div>";
    return;
}
?>

<div class="container my-3">
    <h2 class="text-center mb-5">Detalles del producto</h2>

    <div class="card shadow-sm rounded-4 d-flex flex-column flex-md-row overflow-hidden" style="min-height: 450px;">
        <div class="col-md-6 d-flex align-items-center justify-content-center border-end" style="min-height: 450px; padding: 0;">
            <img src="<?= htmlspecialchars($producto->getRutaImagen()); ?>" alt="<?= htmlspecialchars($producto->getNombre()); ?>" class="img-fluid w-100 h-100" style="object-fit: contain;">
        </div>

        <div class="card-body col-md-6 d-flex flex-column justify-content-center p-4">
            <h2><?= htmlspecialchars($producto->getNombre()); ?></h2>
            <p><?= $producto->getDescripcion(); ?></p>
            <p class="fs-4 fw-bold">Precio: $<?= number_format($producto->getPrecio(), 2, ',', '.'); ?></p>

            <form method="POST" action="carrito.php">
                <input type="hidden" name="agregar_id" value="<?= $producto->getId(); ?>">
                <button type="submit" class="btn btn-dark mt-4 py-2 px-4">
                    Agregar al carrito
                </button>
            </form>
        </div>
    </div>
</div>
