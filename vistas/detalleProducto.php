<?php
require_once __DIR__ . '/../classes/Producto.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<div class='container my-5'><h2>Producto no especificado.</h2></div>";
    exit;
}

// Cargar producto con método estático (con PDO) para evitar usar JSON
$producto = Producto::get_x_id(intval($id));
if (!$producto) {
    echo "<div class='container my-5'><h2>Producto no disponible.</h2></div>";
    exit;
}

// Reconstruir carrito actual desde POST, si viene (IDs y cantidades)
$carrito_actual = $_POST['carrito'] ?? [];
if (!is_array($carrito_actual)) {
    $carrito_actual = [];
}
?>

<div class="container my-3">
    <h2 class="mb-5">Detalles del producto</h2>

    <div class="card shadow-sm rounded-4 d-flex flex-column flex-md-row overflow-hidden" style="min-height: 450px; border: none !important;">
        <div class="col-md-6 d-flex align-items-center justify-content-center border-end" style="min-height: 450px; padding: 0;">
            <img src="<?= $producto->getRutaImagen(); ?>" alt="<?= $producto->getNombre(); ?>" class="img-fluid w-100 h-100" style="object-fit: contain;">
        </div>

        <div class="card-body col-md-6 d-flex flex-column justify-content-center p-4">
            <h2><?= $producto->getNombre(); ?></h2>
            <div class="mb-2">
                <?php foreach ($producto->getCategorias() as $cat): ?>
                    <span class="badge bg-white text-dark me-1" style="border: 1px solid #000;"><?= $cat['nombre']; ?></span>
                <?php endforeach; ?>
            </div>
            <p><?= $producto->getDescripcion(); ?></p>
            <p class="fs-4 fw-bold">Precio: $<?= number_format($producto->getPrecio(), 2, ',', '.'); ?></p>

            <form method="post" action="carrito.php" class="mt-4">
                <?php foreach ($carrito_actual as $id => $cantidad): ?>
                    <input type="hidden" name="carrito[<?= intval($id) ?>]" value="<?= intval($cantidad) ?>">
                <?php endforeach; ?>

                <input type="hidden" name="accion" value="agregar">
                <input type="hidden" name="producto_id" value="<?= intval($producto->getId()) ?>">
                <button type="submit" class="btn btn-dark py-3 px-4"><i class="fas fa-plus mx-2"></i>Agregar al carrito</button>
            </form>
        </div>
    </div>
</div>
