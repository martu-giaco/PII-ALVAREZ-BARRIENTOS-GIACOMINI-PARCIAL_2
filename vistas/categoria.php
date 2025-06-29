<?php
require_once __DIR__ . '/../classes/Conexion.php';
require_once __DIR__ . '/../classes/Producto.php';

$categoria_nombre = $_GET['nombre'] ?? null;

if (!$categoria_nombre) {
    echo "<p>No se especificó ninguna categoría.</p>";
    exit;
}

$conexion = new Conexion();
$db = $conexion->getConexion();

$stmtCat = $db->prepare("SELECT * FROM categorias WHERE nombre = :nombre");
$stmtCat->execute(['nombre' => $categoria_nombre]);
$categoria = $stmtCat->fetch(PDO::FETCH_ASSOC);

if (!$categoria) {
    echo "<p>Categoría no encontrada.</p>";
    exit;
}

$productos = Producto::productosPorCategoriaCompletos($categoria_nombre);
?>

<h2>Productos en la categoría: <?= htmlspecialchars($categoria_nombre); ?></h2>

<?php if (!empty($productos)): ?>
    <div class="row">
        <?php foreach ($productos as $producto): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="<?= $producto->getRutaImagen() ?>" alt="<?= htmlspecialchars($producto->getNombre()) ?>" class="card-img-top" style="object-fit: contain; max-height: 250px;" />
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
                                    $urlCat = 'index.php?sec=categoria&nombre=' . urlencode($nombreCat);
                                    $cats[] = "<a href=\"$urlCat\">" . htmlspecialchars($nombreCat) . "</a>";
                                }
                                echo implode(', ', $cats);
                                ?>
                            </p>
                        <?php endif; ?>

                        <a href="index.php?sec=detalleProducto&id=<?= $producto->getId(); ?>" class="btn btn-dark text-light py-3 w-75 mx-auto my-2">
                            <i class="fas fa-info-circle me-1"></i> Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No hay productos en esta categoría.</p>
<?php endif; ?>
