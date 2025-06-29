<div class="container-productos m-5">
<?php
require_once __DIR__ . '/../classes/Conexion.php';
require_once __DIR__ . '/../classes/Producto.php';

$conexion = new Conexion();
$db = $conexion->getConexion();

// Obtener todas las categorías
$stmt = $db->prepare("SELECT * FROM categorias");
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener filtro de categoría por GET
$categoria_nombre = $_GET['nombre'] ?? null;

// Obtener productos según filtro o todos
if ($categoria_nombre) {
    $productos = Producto::productosPorCategoriaCompletos($categoria_nombre);
} else {
    $productos = Producto::todosProductosCompletos();
}
?>

<main class="container my-5">
    <div class="row justify-content-center">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <?php
                    // Debug ruta imagen (quita esta línea cuando esté todo OK)
                    echo "<!-- IMG PATH: " . htmlspecialchars($producto->getRutaImagen()) . " -->";
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img
                            src="<?= htmlspecialchars($producto->getRutaImagen()) ?>"
                            alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                            class="card-img-top"
                        >
                        <div class="card-body d-flex flex-column">
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
                                        $nombreCat = htmlspecialchars($cat['nombre']);
                                        $urlCat = '?nombre=' . urlencode($cat['nombre']);
                                        $cats[] = "<a href=\"$urlCat\">$nombreCat</a>";
                                    }
                                    echo implode(', ', $cats);
                                    ?>
                                </p>
                            <?php endif; ?>

                            <a href="index.php?sec=detalleProducto&id=<?= $producto->getId(); ?>" class="btn btn-dark mt-auto">
                                <i class="fas fa-info-circle me-1"></i> Ver Detalles
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

    <hr class="my-5">
    <h3 class="text-center mb-4">Explorar categorías</h3>
    <div class="d-flex justify-content-center flex-wrap gap-4">
        <?php foreach ($categorias as $cat): ?>
            <div class="card text-center" style="width: 14rem;">
                <img src="assets/imagenes/categorias-fotitos/<?= strtolower($cat['nombre']); ?>-categoria.png"
                     class="card-img-top"
                     alt="<?= htmlspecialchars($cat['nombre']); ?>">

                <div class="card-body">
                    <a href="?nombre=<?= urlencode($cat['nombre']); ?>" class="btn btn-primary stretched-link">
                        <?= htmlspecialchars($cat['nombre']); ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</div>
