<?php
require_once __DIR__ . '/../classes/Producto.php';

// Obtener nombre de categoría por GET (minúsculas para comparación)
$categoria_nombre = $_GET['nombre'] ?? null;

if (!$categoria_nombre) {
    echo "<div class='container my-5'><h2>Categoría no especificada.</h2></div>";
    return;
}

// Cargo todos los productos con sus categorías desde la DB
$productos = Producto::cargarProductosConCategorias();

// Buscar el ID de la categoría por nombre (ignorando mayúsculas/minúsculas)
$categoria_id = null;
foreach ($productos as $producto) {
    foreach ($producto->getCategorias() as $cat) {
        if (strtolower($cat['nombre']) === strtolower($categoria_nombre)) {
            $categoria_id = $cat['id'];
            break 2; // salir de ambos foreach
        }
    }
}

if (!$categoria_id) {
    echo "<div class='container my-5'><h2>Categoría no encontrada.</h2></div>";
    return;
}

// Filtrar productos que pertenezcan a la categoría buscada
$productos_filtrados = [];
foreach ($productos as $producto) {
    foreach ($producto->getCategorias() as $cat) {
        if ($cat['id'] === $categoria_id) {
            $productos_filtrados[] = $producto;
            break;
        }
    }
}
?>

<div class="container-productos m-5">
    <main class="container-fluid my-5">
        <div class="row justify-content-start">
            <h2 class="mb-4">Productos en categoría: <?= ucwords(htmlspecialchars($categoria_nombre)) ?></h2>

            <?php if (!empty($productos_filtrados)): ?>
                <?php foreach ($productos_filtrados as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card card-producto h-100 shadow-sm">
                            <img src="<?= $producto->getRutaImagen() ?>" alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                                class="card-img-top" style="object-fit: contain;" />
                            <div class="card-body d-flex flex-column justify-content-end">
                                <h5 class="card-title"><?= htmlspecialchars($producto->getNombre()); ?></h5>

                                <p class="card-text text-primary fw-semibold">
                                    $<?= number_format($producto->getPrecio(), 2, ',', '.'); ?>
                                </p>

                                <a href="index.php?sec=detalleProducto&id=<?= $producto->getId(); ?>"
                                    class="btn btn-dark py-3 my-2">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No hay productos para mostrar en esta categoría.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>
