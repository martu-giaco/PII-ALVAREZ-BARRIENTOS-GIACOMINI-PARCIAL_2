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

$imagenes = method_exists($producto, 'getImagenes') ? $producto->getImagenes() : [];
$categorias = $producto->getCategorias();
?>

<div class="container my-3">
    <h2 class="text-center mb-5">Detalles del producto</h2>

    <div class="card shadow-sm rounded-4 d-flex flex-column flex-md-row overflow-hidden">

        <!-- IMAGEN O CARRUSEL -->
        <div class="col-md-6 p-4 border-end">
            <?php if (!empty($imagenes)): ?>
                <div id="carouselProducto" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php foreach ($imagenes as $i => $img): ?>
                            <button type="button" data-bs-target="#carouselProducto" data-bs-slide-to="<?= $i; ?>"
                                class="<?= $i === 0 ? 'active' : ''; ?>" aria-current="<?= $i === 0 ? 'true' : 'false'; ?>"
                                aria-label="Slide <?= $i + 1; ?>"></button>
                        <?php endforeach; ?>
                    </div>

                    <div class="carousel-inner rounded">
                        <?php foreach ($imagenes as $i => $img): ?>
                            <div class="carousel-item <?= $i === 0 ? 'active' : ''; ?>">
                                <img src="assets/imagenes/prods/<?= htmlspecialchars($img['ruta']); ?>"
                                    alt="<?= htmlspecialchars($producto->getNombre()) ?> imagen <?= $i + 1 ?>"
                                    class="card-img-top" style="object-fit: contain; max-height: 350px;" />
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProducto"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselProducto"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>

            <?php else: ?>
                <img src="<?= htmlspecialchars($producto->getRutaImagen()); ?>"
                    alt="<?= htmlspecialchars($producto->getNombre()); ?>" class="img-fluid rounded w-100"
                    style="object-fit: contain; max-height: 350px;">
            <?php endif; ?>
        </div>

        <!-- DETALLES DEL PRODUCTO -->
        <div class="card-body col-md-6 d-flex flex-column justify-content-center p-4">
            <h2 class="card-title"><?= htmlspecialchars($producto->getNombre()); ?></h2>

            <?php if (!empty($categorias)): ?>
                <p class="mb-2">
                    <strong>Categoría<?= count($categorias) > 1 ? 's' : '' ?>:</strong>
                    <?php foreach ($categorias as $cat): ?>
                        <span class="badge bg-dark me-1"><?= htmlspecialchars($cat['nombre']); ?></span>
                    <?php endforeach; ?>
                </p>
                <p><?= $producto->getDescripcion(); ?></p>
            <?php endif; ?>

            <p class="fs-4 fw-bold mt-3">
                <strong>Precio:</strong> $<?= number_format($producto->getPrecio(), 2, ',', '.'); ?>
            </p>

            <a href="#" class="btn btn-light btn-lg mt-4 align-self-start">
                <i class="fas fa-cart-plus me-2"></i> Agregar al Carrito
            </a>
        </div>
    </div>
</div>