<?php

require_once __DIR__ . '/../classes/Categoria.php';
require_once __DIR__ . '/../classes/Conexion.php';
require_once __DIR__ . '/../classes/Producto.php';
$categorias = Categoria::obtenerCategorias();
?>

<div class="container-inicio">
    <section class="header m-3">
        <h2 class="text-center p-5">Bienvenido a la tienda oficial de Apple Latino América</h2>
    </section>
    <section class="text-center container">
        <div class="row g-4">
            <div id="ipads-colores" class="col-12 col-md-6">
                <h3>Un color para cada personalidad</h3>
                <a href="#">Descubrílos</a>
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
        <a href="#" class="mt-5 d-inline-block">Ver más</a>
    </section>
    
    
</div>