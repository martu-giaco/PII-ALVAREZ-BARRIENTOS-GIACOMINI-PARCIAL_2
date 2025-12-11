<?php

require_once __DIR__ . '/../classes/Categoria.php';
require_once __DIR__ . '/../classes/Conexion.php';
require_once __DIR__ . '/../classes/Producto.php';
$categorias = Categoria::obtenerCategorias();

// Cargo todas las categorías para el carousel
$conexion = (new Conexion())->getConexion();
$PDOStatement = $conexion->prepare("SELECT * FROM categorias ORDER BY nombre");
$PDOStatement->execute();
$categorias = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container-inicio">
    <section class="header m-3">
        <h2 class="text-center p-5">Bienvenido a la tienda oficial de Apple Latino América</h2>
    </section>
    <section class="text-center container">
        <div class="row g-4">
            <div id="ipads-colores" class="col-12 col-md-6">
                <h3>Un color para cada personalidad</h3>
                <a href="http://localhost/PII-ALVAREZ-BARRIENTOS-GIACOMINI-PARCIAL_2/index.php?sec=categoria&nombre=iPad">Descubrílos</a>
            </div>
            <div id="descuento-estudiantes" class="col-12 col-md-6">
                <h3>Disfrutá de hasta un 30% de descuento</h3>
                <p>Comprobando que sos estudiante universitario</p>
                <a href="https://www.apple.com/cl-edu/store">Soy estudiante!</a>
            </div>
        </div>
    </section>
    <section class="text-center m-3 mb-5 p-5" id="macbook-promo">
        <p class="mb-0">Nueva</p>
        <h3 class="px-5">MacBook Air</h3>
        <a href="http://localhost/PII-ALVAREZ-BARRIENTOS-GIACOMINI-PARCIAL_2/index.php?sec=detalleProducto&id=7" class="mt-5 d-inline-block">Ver más</a>
    </section>
    
<h3 class="mt-5 mb-5 text-center">Explorar categorías</h3>
<div class="container-productos m-5">
    <main class="container-fluid my-5">
        <div id="carouselCategorias" class="carousel slide mt-5 pt-5" data-bs-ride="carousel" data-bs-interval="5000"
            data-bs-wrap="true">
            <div class="carousel-inner">

                <?php
                $totalCategorias = count($categorias);
                $itemsPorSlide = 6;
                $contador = 0;
                foreach ($categorias as $index => $cat):
                    // Comenzar un nuevo slide
                    if ($contador % $itemsPorSlide === 0): ?>
                        <div class="carousel-item <?= $contador === 0 ? 'active' : '' ?>">
                            <div class="d-flex justify-content-center gap-4 flex-wrap">
                            <?php endif; ?>

                            <!-- Tarjeta de categoría -->
                            <div class="card" style="width: 12rem;">
                                <img src="assets/imagenes/categorias-fotitos/<?= $cat['imagen_categoria']; ?>"
                                    class="card-img-top mx-auto d-block" alt="<?= $cat['nombre']; ?>"
                                    style="object-fit: cover;">
                                <div class="card-body d-flex justify-content-center">
                                    <a href="index.php?sec=categoria&nombre=<?= urlencode($cat['nombre']); ?>"
                                        class="stretched-link text-decoration-none text-dark fw-semibold">
                                        <?= $cat['nombre']; ?>
                                    </a>
                                </div>
                            </div>

                            <?php
                            $contador++;

                            // Cerrar el slide actual
                            if ($contador % $itemsPorSlide === 0 || $contador === $totalCategorias): ?>
                            </div>
                        </div>
                    <?php endif;
                endforeach; ?>

            </div>

            <!-- Controles del carrusel -->
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
    
</div>