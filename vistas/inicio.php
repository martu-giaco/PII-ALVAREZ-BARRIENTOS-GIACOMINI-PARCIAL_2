<?php

require_once __DIR__ . '/../classes/Categoria.php';
$categorias = Categoria::obtenerCategorias();
?>

<div class="container-inicio">
    <section class="header m-3">
        <h2 class="text-center p-5">Bienvenido a la tienda oficial de Apple Latino América</h2>
    </section>
    <section class="d-flex text-center justify-content-around">
        <div id="ipads-colores" class="m-3">
            <h3>Un color para cada personalidad</h3>
            <a href="#">Descubrílos</a>
        </div>
        <div id="descuento-estudiantes" class="m-3">
            <h3>Disfrutá de hasta un 30% de descuento</h3>
            <p>Comprobando que sos estudiante universitario</p>
            <a href="#">Soy estudiante!</a>
        </div>
    </section>
    <section class="text-center m-3 mb-5 p-5" id="macbook-promo">
        <p class="mb-0">Nueva</p>
        <h3 class="px-5">MacBook Air</h3>
        <a href="#" class="mt-5 d-inline-block">Ver más</a>
    </section>
    <section class="categorias mt-5 pt-5 mb-5">
        <h3 class="mb-4 text-center">Explorar categorías</h3>

        <?php if (!empty($categorias)): ?>
            <div id="carouselCategorias" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000"
                data-bs-wrap="true">
                <div class="carousel-inner">
                    <!-- Un solo carousel-item con todas las categorías -->
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center gap-4 flex-wrap">
                            <?php foreach ($categorias as $cat): ?>
                                <div class="card shadow-sm" style="width: 15rem;">
                                    <img src="assets/imagenes/categorias-fotitos/<?= htmlspecialchars(str_replace(' ', '-', strtolower($cat->getNombre()))) ?>-categoria.png"
                                        class="card-img-top mx-auto d-block" alt="<?= htmlspecialchars($cat->getNombre()); ?>"
                                        style="height: 100px; object-fit: cover;">
                                    <div class="card-body d-flex justify-content-center">
                                        <a href="index.php?sec=categoria&nombre=<?= urlencode($cat->getNombre()); ?>"
                                            class="stretched-link text-decoration-none text-dark fw-semibold">
                                            <?= htmlspecialchars($cat->getNombre()); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Botones de control (aunque con un solo slide no hace mucho) -->
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
        <?php else: ?>
            <p class="text-center">No hay categorías para mostrar.</p>
        <?php endif; ?>

    </section>
</div>