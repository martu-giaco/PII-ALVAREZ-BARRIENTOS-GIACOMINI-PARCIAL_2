<?php
require_once __DIR__ . '/../classes/Producto.php';
require_once __DIR__ . '/../classes/Categoria.php';

// Obtener el nombre de la categoría desde el parámetro GET
$categoria_nombre = $_GET['nombre'] ?? null;

if (!$categoria_nombre) {
    // Si no se especifica categoría, mostrar mensaje y detener ejecución
    echo "<div class='container my-5'><h2>Categoría no especificada.</h2></div>";
    return;
}

// Obtener todas las categorías disponibles
$categorias = Categoria::obtenerCategorias();

// Buscar el ID de la categoría que coincida (sin importar mayúsculas/minúsculas)
$categoria_id = null;
foreach ($categorias as $cat) {
    if (strtolower($cat->getNombreCategoria()) === strtolower($categoria_nombre)) {
        $categoria_id = $cat->getIdCategoria();
        break;
    }
}

if (!$categoria_id) {
    // Si no se encuentra la categoría, mostrar mensaje y detener ejecución
    echo "<div class='container my-5'><h2>Categoría no encontrada.</h2></div>";
    return;
}

// Conexión a la base de datos
$conexion = (new Conexion())->getConexion();

// Consulta para obtener productos que pertenecen a la categoría encontrada
$query = "
    SELECT p.* 
    FROM productos p
    JOIN producto_categoria pc ON p.id = pc.producto_id
    WHERE pc.categoria_id = :categoria_id
";
$PDOStatement = $conexion->prepare($query);
$PDOStatement->execute(['categoria_id' => $categoria_id]);
$productosData = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

// Array para almacenar objetos Producto con sus categorías asociadas
$productos_filtrados = [];

// Por cada producto, obtenemos sus categorías y creamos el objeto Producto
$queryCategorias = "
    SELECT c.id, c.nombre
    FROM categorias c
    JOIN producto_categoria pc ON c.id = pc.categoria_id
    WHERE pc.producto_id = :producto_id
";
$PDOStatementCategorias = $conexion->prepare($queryCategorias);

foreach ($productosData as $fila) {
    // Ejecutar consulta para obtener categorías del producto actual
    $PDOStatementCategorias->execute(['producto_id' => $fila['id']]);
    $categoriasProducto = $PDOStatementCategorias->fetchAll(PDO::FETCH_ASSOC);

    // Crear objeto Producto con datos y categorías
    $productos_filtrados[] = new Producto(
        $fila['id'],
        $fila['nombre'],
        $fila['descripcion'],
        $fila['precio'],
        $categoriasProducto,
        $fila['imagen']
    );
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
                            <img src="<?= htmlspecialchars($producto->getImagen()) ?>"
                                alt="<?= htmlspecialchars($producto->getNombre()) ?>" 
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
