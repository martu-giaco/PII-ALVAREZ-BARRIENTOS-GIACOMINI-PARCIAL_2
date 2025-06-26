<div class="container-productos m-5">
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
    <div class="row justify-content-center">
        <?php foreach($productos as $producto): ?>
        <div class="col-md-4 mb-5">
            <div class="card h-100">
            <img src="assets/imagenes/prods/<?php echo $producto['imagen']; ?>" class="card-img-top p-5" alt="<?php echo ($producto['nombre']); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                    <p class="card-text">$<?php echo$producto['precio']?></p>
                    <a href="?sec=producto&id=<?= $producto['id']; ?>" class="btn mt-3">Ver Detalles</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>
</div>
