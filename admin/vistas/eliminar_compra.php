<?php
require_once __DIR__ . '/../../functions/autoload.php';

Autenticacion::verify(true); // Solo admin

$id_compra = $_GET['id'] ?? null;
if (!$id_compra) {
    Alerta::add_alerta('error', 'Compra no encontrada.');
    header("Location: ?sec=compras");
    exit;
}

$compra = Compra::getPorId($id_compra);
if (!$compra) {
    Alerta::add_alerta('error', 'Compra no encontrada.');
    header("Location: ?sec=compras");
    exit;
}

$compra->cargarDetalles();
?>

<h2 class="mb-3">¿Estás seguro de eliminar la compra #<?= $compra->getId(); ?>?</h2>

<div class="card my-4">
    <div class="card-body">
        <p><strong>Cliente:</strong> <?= htmlspecialchars($compra->getNombreCliente()); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($compra->getEmail()); ?></p>
        <p><strong>Productos:</strong></p>
        <ul>
            <?php foreach ($compra->getProductos() as $prod): ?>
                <li><?= htmlspecialchars($prod['nombre']); ?> x <?= $prod['cantidad']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<form action="actions/eliminar_compra_acc.php" method="POST">
    <input type="hidden" name="id_compra" value="<?= $compra->getId(); ?>">
    <button type="submit" class="btn btn-danger py-2 px-4">Eliminar</button>
    <a href="?sec=compras" class="btn btn-secondary py-2 px-4">Cancelar</a>
</form>



