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

    <section class="categorias mt-5 pt-5 mb-5">
        <h2 class="text-center">Encontrá lo que estás buscando</h2>
        <!-- AGREGAR LOS RESPECTIVOS LINKS DE LAS CATEGORIAS Y DESPUES BORRAR ESTE PARRAFO no me sale hacer un comentario, asssdraaaaaaaaaaaaa -->
        <div class="d-flex justify-content-center flex-wrap mt-4">
            <div class="card" style="width: 18rem;">
                <img src="assets/imagenes/categorias-fotitos/mac-categoria.png" class="card-img-top" alt="Mac">
                <div class="card-body">
                    <a href="#" class="btn btn-primary stretched-link">Mac</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="assets/imagenes/categorias-fotitos/iphone-categoria.png" class="card-img-top" alt="iPhone">
                <div class="card-body">
                    <a href="#" class="btn btn-primary stretched-link">iPhone</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="assets/imagenes/categorias-fotitos/ipad-categoria.png" class="card-img-top" alt="iPad">
                <div class="card-body">
                    <a href="#" class="btn btn-primary stretched-link">iPad</a>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <img src="assets/imagenes/categorias-fotitos/airpods-categoria.png" class="card-img-top" alt="airpods">
                <div class="card-body">
                    <a href="#" class="btn btn-primary stretched-link">Airpods</a>
                </div>
            </div>
        </div>
    </section>
    
</div>
