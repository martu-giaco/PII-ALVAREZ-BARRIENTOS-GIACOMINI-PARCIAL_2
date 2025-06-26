<div class="container-detalleProducto m-5">
    <?php
require_once "classes/producto.php";

    $id = isset($_GET['id']) ? $_GET['id'] : '';

    $producto = Producto::todosProductos();

?>
<?php
    if(!is_null($producto)){
?>

<div class="container my-3 producto">
    <h1>Detalles</h1>

    <div class="card my-2 d-flex flex-row">
        <div class="este">
        <div id="carouselIndicators" class="carousel slide">
            <div class="carousel-indicators">
            <?php foreach ($producto['/*aca irian las fotos de cada prod NO SOLO LA PREVIEW!!! todas, están ahí en cada carpetita*/'] as $index => $image) { ?>
                <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="<?= $index; ?>" 
                        class="<?= $index === 0 ? 'active' : ''; ?>" 
                        aria-current="<?= $index === 0 ? 'true' : 'false'; ?>" 
                        aria-label="Slide <?= $index + 1; ?>"></button>
            <?php } ?>
            </div>
            <div class="carousel-inner">
            <?php foreach ($producto['/*aca irian las fotos de cada prod NO SOLO LA PREVIEW!!! todas, están ahí en cada carpetita*/'] as $index => $image) { ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
                        <img src="assets/imagenes/prods/<?php echo $image; ?>.png" class="d-block" alt="Imagen del producto <?php echo $producto['nombre']; ?>">
                </div>
            <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        </div>

        <div class="card-body">
            <h2 class="card-title"> <?php echo $producto['nombre']; ?></h2>
            <p class="card-text"><?php echo $producto['descripcion']; ?></p>
            <p class="precio-producto">$<?php echo $producto['precio']; ?></p>
            <a href="#" class="btn btn-primary">Agregar al Carrito</a>
        </div>
    </div> 
</div>

<?php 
}else{
?>
    <h2>Producto no disponible</h2>
<?php
}
?>

</div>

