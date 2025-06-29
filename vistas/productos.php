<?php
require_once __DIR__ . '/../classes/Conexion.php';
require_once __DIR__ . '/../classes/Producto.php';

$conexion = new Conexion();
$db = $conexion->getConexion();

$categoria_nombre = $_GET['nombre'] ?? null;

// Si se recibe categoría, redirigir a la vista específica de categoría
if ($categoria_nombre) {
    header("Location: vistas/categoria.php?nombre=" . urlencode($categoria_nombre));
    exit;
}

// Si no hay categoría, mostrar todos los productos
$productos = Producto::todosProductosCompletos();

// Obtener todas las categorías para el carrusel
$stmt = $db->prepare("SELECT * FROM categorias");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-productos m-5">

    <main class="container-fluid my-5">
        <div class="row justify-content-center">
            <h2 class="mb-4">Todos los productos</h2>

            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= $producto->getRutaImagen() ?>" alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                                class="card-img-top" style="object-fit: contain; max-height: 250px;" />
                            <div class="card-body d-flex flex-column justify-content-end">
                                <h5 class="card-title"><?= htmlspecialchars($producto->getNombre()); ?></h5>

                                <p class="card-text text-primary fw-semibold">
                                    $<?= number_format($producto->getPrecio(), 2, ',', '.'); ?>
                                </p>

                                <?php if (!empty($producto->getCategorias())): ?>
                                    <p>
                                        Categoría:
                                        <?php
                                        $cats = [];
                                        foreach ($producto->getCategorias() as $cat) {
                                            $nombreCat = $cat['nombre'];
                                            $urlCat = 'vistas/categoria.php?nombre=' . urlencode($nombreCat);
                                            $cats[] = "<a href=\"$urlCat\">" . htmlspecialchars($nombreCat) . "</a>";
                                        }
                                        echo implode(', ', $cats);
                                        ?>
                                    </p>
                                <?php endif; ?>

                                <a href="index.php?sec=detalleProducto&id=<?= $producto->getId(); ?>"
                                    class="btn py-3 w-75 mx-auto my-2">
                                    <i class="fas fa-info-circle me-1"></i> Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No hay productos para mostrar.</p>
                </div>
            <?php endif; ?>
        </div>

        <hr class="my-5">

        <h3 class="mb-4">Explorar categorías</h3>
        <?php
        // Asegurarse que $categorias esté definido y sea un array
        if (!isset($categorias) || !is_array($categorias)) {
            $categorias = [];
        }

        $chunks = array_chunk($categorias, 4); // 5 tarjetas por slide
        ?>

        <div id="carouselCategorias" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1000"
            data-bs-wrap="true">
            <div class="carousel-inner">
                <?php foreach ($chunks as $index => $chunk): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                        <div class="d-flex justify-content-center gap-4 flex-wrap">
                            <?php foreach ($chunk as $cat): ?>
                                <div class="card" style="width: 15rem;">
                                    <img src="assets/imagenes/categorias-fotitos/<?= str_replace(' ', '-', strtolower($cat['nombre'])) ?>-categoria.png"
                                        class="card-img-top mx-auto d-block" alt="<?= htmlspecialchars($cat['nombre']); ?>"
                                        style="height: 150px; object-fit: cover;">
                                    <div class="card-body d-flex justify-content-center">
                                        <a href="index.php?sec=categoria&nombre=<?= urlencode($cat['nombre']); ?>"
                                            class="stretched-link text-decoration-none text-dark fw-semibold">
                                            <?= htmlspecialchars($cat['nombre']); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselCategorias"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselCategorias"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>

    </main>
</div>