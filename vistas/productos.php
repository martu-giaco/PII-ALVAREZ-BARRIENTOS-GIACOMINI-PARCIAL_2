
<?php
require_once 'classes/Conexion.php';

$conexion = new Conexion();
$db = $conexion->getConexion();

$stmt = $db->prepare("SELECT * FROM productos");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container my-5">
    <h2 class="mb-4">Productos</h2>
    <div class="row">
        <?php foreach($productos as $producto): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
            <img src="assets/imagenes/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="<?php echo ($producto['nombre']); ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                <p class="card-text">$<?php echo$producto['precio'], 2, ',', '.'; ?></p>
            </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

