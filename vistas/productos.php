<?php
require_once __DIR__ . '/../classes/Conexion.php';
require_once __DIR__ . '/../classes/Producto.php';


$productos = Producto::cargarProductosConCategorias();

// Cargo todas las categorías para el carousel
$conexion = (new Conexion())->getConexion();
$PDOStatement = $conexion->prepare("SELECT * FROM categorias ORDER BY nombre");
$PDOStatement->execute();
$categorias = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
?>



<div class="container-productos m-5">
    <main class="container-fluid my-5">
        <div class="row justify-content-center">
            <h2 class="mb-4">Todos los productos</h2>

            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card card-producto h-100 shadow-sm">
                            <img src="<?= $producto->getRutaImagen() ?>" alt="<?= $producto->getNombre() ?>"
                                class="card-img-top" style="object-fit: contain;" />
                            <div class="card-body d-flex flex-column justify-content-end">
                                <h5 class="card-title"><?= $producto->getNombre(); ?></h5>
                                <!-- Mostrar categorías -->
                                <div class="mb-2">
                                    <?php foreach ($producto->getCategorias() as $cat): ?>
                                        <span class="badge fs-6 bg-white text-dark me-1" style="border: 1px solid #000;">
                                            <?= $cat['nombre']; ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>

                                <p class="card-text text-primary fw-semibold">
                                    $<?= number_format($producto->getPrecio(), 2, ',', '.'); ?>
                                </p>
                                <a href="index.php?sec=detalleProducto&id=<?= $producto->getId(); ?>" class="btn py-3 my-2">
                                    Ver Detalles
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

        <h3 class="mt-5 mb-5 text-center">Explorar categorías</h3>

        <?php $chunks = array_chunk($categorias, 4); ?>

        <div id="carouselCategorias" class="carousel slide mt-5 pt-5" data-bs-ride="carousel" data-bs-interval="5000"
            data-bs-wrap="true">
            <div class="carousel-inner">
                <?php foreach ($chunks as $index => $chunk): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="d-flex justify-content-center gap-4 flex-wrap">
                            <?php foreach ($chunk as $cat): ?>
                                <div class="card" style="width: 12rem;">
                                    <img src="assets/imagenes/categorias-fotitos/<?= str_replace(' ', '-', strtolower($cat['nombre'])) ?>-categoria.png"
                                        class="card-img-top mx-auto d-block" alt="<?= $cat['nombre']; ?>"
                                        style="object-fit: cover;">
                                    <div class="card-body d-flex justify-content-center">
                                        <a href="index.php?sec=categoria&nombre=<?= urlencode($cat['nombre']); ?>"
                                            class="stretched-link text-decoration-none text-dark fw-semibold">
                                            <?= $cat['nombre']; ?>
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