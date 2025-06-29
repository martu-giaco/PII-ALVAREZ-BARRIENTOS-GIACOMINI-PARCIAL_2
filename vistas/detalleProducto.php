<?php
require_once __DIR__ . '/../classes/Conexion.php';
require_once __DIR__ . '/../classes/producto.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='container my-5'><h2>Producto no especificado.</h2></div>";
    return;
}

$producto = Producto::get_x_id((int)$id);

if (!$producto) {
    echo "<div class='container my-5'><h2>Producto no disponible.</h2></div>";
    return;
}

$imagenes = method_exists($producto, 'getImagenes') ? $producto->getImagenes() : [];
$imagenes = $imagenes ?? [];
$fotoPrincipal = $producto->getFoto();
$categorias = $producto->getCategorias();
?>

<div class="container my-5">
    <h2 class="text-center mb-5 text-dark">Detalles del producto</h2>

    <div class="card shadow rounded-4 d-flex flex-column flex-md-row overflow-hidden bg-white text-dark">
        <!-- Imágenes -->
        <div class="col-md-6 p-4 border-end">
            <?php if (!empty($imagenes)): ?>
                <div id="carouselProducto" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php foreach ($imagenes as $index => $image): ?>
                            <button type="button" data-bs-target="#carouselProducto" data-bs-slide-to="<?= $index; ?>"
                                class="<?= $index === 0 ? 'active' : ''; ?>" aria-current="<?= $index === 0 ? 'true' : 'false'; ?>"
                                aria-label="Slide <?= $index + 1; ?>"></button>
                        <?php endforeach; ?>
                    </div>

                    <div class="carousel-inner rounded">
                        <?php foreach ($imagenes as $index => $image): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                                <img src="assets/imagenes/prods/<?= htmlspecialchars($image['ruta'] ?? $image); ?>"
                                     class="d-block w-100 img-fluid"
                                     style="object-fit: contain; max-height: 350px;" 
                                     alt="Imagen <?= $index + 1; ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProducto" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselProducto" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            <?php elseif ($fotoPrincipal): ?>
                <img src="assets/imagenes/prods/<?= htmlspecialchars($fotoPrincipal); ?>" 
                     alt="<?= htmlspecialchars($producto->getNombre()); ?>" 
                     class="img-fluid rounded w-100" style="object-fit: contain; max-height: 350px;">
            <?php else: ?>
                <p>No hay imágenes disponibles para este producto.</p>
            <?php endif; ?>
        </div>

        <!-- Detalles -->
        <div class="card-body col-md-6 d-flex flex-column justify-content-center p-4">
            <h2 class="card-title"><?= htmlspecialchars($producto->getNombre()); ?></h2>

            <!-- Categorías -->
            <?php if (!empty($categorias)): ?>
                <p class="mb-2">
                    <strong>Categoría<?= count($categorias) > 1 ? 's' : '' ?>:</strong>
                    <?php foreach ($categorias as $index => $cat): ?>
                        <span class="badge bg-dark"><?= htmlspecialchars($cat['nombre']); ?></span>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>

            <p class="fs-4 fw-bold text-dark mt-2">
                <strong>Precio:</strong> $<?= number_format($producto->getPrecio(), 2, ',', '.'); ?>
            </p>
            <?php if (!empty($producto->getCategorias())): ?>
                <p class="mb-3">
                    
                </p>
            <?php endif; ?>


            <a href="#" class="btn btn-outline-dark btn-lg mt-3 align-self-start">
                <i class="fas fa-cart-plus me-2"></i> Agregar al Carrito
            </a>
        </div>
    </div>
</div>
