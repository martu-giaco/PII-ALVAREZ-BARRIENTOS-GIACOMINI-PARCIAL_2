<?php
require_once(__DIR__ . '/../functions/autoload.php');

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['loggedIn'])) {
    echo '<div class="container py-5">';
    echo '<h2>No estás logueado</h2>';
    echo '<p>Por favor <a href="index.php?sec=login">Inicia sesión</a> para ver tus compras.</p>';
    echo '</div>';
    exit;
}

$id_usuario = $_SESSION['loggedIn']['id_usuario'] ?? null;

if (!$id_usuario) {
    echo '<div class="container py-5">';
    echo '<h2>No se pudo identificar al usuario</h2>';
    echo '</div>';
    exit;
}

// Obtener compras del usuario
$compras = Compra::obtenerPorUsuario($id_usuario);
?>

<div class="container py-5">
    <h1 class="mb-4">Mis Compras</h1>

    <?php if (empty($compras)): ?>
        <div class="alert alert-info text-center">
            No has realizado ninguna compra aún.
        </div>
        <div class="text-center">
            <a href="index.php?sec=productos" class="btn btn-primary btn-lg text-white">Ver Productos</a>
        </div>
    <?php else: ?>
        <?php foreach ($compras as $compra): 
            // Cargar detalles de la compra
            $compra->cargarDetalles();
            $detalles = $compra->getDetalles();
        ?>
            <div class="card mb-5 shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>Compra #<?= $compra->getId(); ?></span>
                    <span><?= date('d/m/Y H:i', strtotime($compra->getFecha())); ?> (<?= ucfirst($compra->getEstado()); ?>)</span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6"><strong>Nombre:</strong> <?= htmlspecialchars($compra->getNombreCliente()); ?></div>
                        <div class="col-md-6"><strong>Email:</strong> <?= htmlspecialchars($compra->getEmail()); ?></div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6"><strong>Dirección:</strong> <?= htmlspecialchars($compra->getDireccion()); ?></div>
                        <div class="col-md-6"><strong>Método de pago:</strong> <?= htmlspecialchars($compra->getMetodoPago()); ?></div>
                    </div>

                    <h5 class="mb-3">Productos:</h5>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                        <?php foreach ($detalles as $detalle): 
                            $subtotal = $detalle['cantidad'] * $detalle['precio_unitario'];
                            $imagen = $compra->getImagenProducto($detalle);

                        ?>
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    <img src="<?= htmlspecialchars($imagen); ?>" class="card-img-top"
     alt="<?= htmlspecialchars($detalle['nombre_producto']); ?>"
     style="height:200px; object-fit:contain;">

                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title"><?= htmlspecialchars($detalle['nombre_producto']); ?></h6>
                                        <p class="text-muted mb-1"><?= htmlspecialchars($detalle['categoria'] ?? 'Sin categoría'); ?></p>
                                        <p class="mb-1">Cantidad: <strong><?= intval($detalle['cantidad']); ?></strong></p>
                                        <p class="mb-1">Precio unitario: $<?= number_format($detalle['precio_unitario'], 2, ',', '.'); ?></p>
                                        <p class="fw-bold mt-auto">Subtotal: $<?= number_format($subtotal, 2, ',', '.'); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-4 text-end fs-5 fw-bold">
                        Total de la compra: $<?= number_format($compra->getTotal(), 2, ',', '.'); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
