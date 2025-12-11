<?php
require_once __DIR__ . '/../../functions/autoload.php';
require_once __DIR__ . '/../../classes/Compra.php';

Autenticacion::verify(true); // Solo admin

$id = $_GET['id'] ?? null;
if (!$id) {
    Alerta::add_alerta('warning', 'ID de compra no proporcionado.');
    header('Location: ?sec=compras');
    exit;
}

$compra = Compra::getPorId($id);
if (!$compra) {
    Alerta::add_alerta('danger', 'Compra no encontrada.');
    header('Location: ?sec=compras');
    exit;
}

$compra->cargarDetalles();
?>

<h2 class="mb-3">Editar Compra #<?= $compra->getId(); ?></h2>
<?= Alerta::get_alertas(); ?>

<form action="actions/editar_compra_acc.php" method="POST" class="mb-4">
    <input type="hidden" name="id_compra" value="<?= $compra->getId(); ?>">

    <div class="mb-3">
        <label for="estado" class="form-label">Estado</label>
        <select name="estado" id="estado" class="form-select">
            <option value="pendiente" <?= $compra->getEstado() === 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
            <option value="completado" <?= $compra->getEstado() === 'completado' ? 'selected' : ''; ?>>Completado</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Guardar cambios</button>
    <a href="?sec=compras" class="btn btn-secondary text-white">Cancelar</a>
</form>

<h4 class="mt-5 mb-3">Productos en la compra</h4>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($compra->getDetalles() as $prod):
        $subtotal = $prod['cantidad'] * $prod['precio_unitario'];
        $imagen = $compra->getImagenProducto($prod);
    ?>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="../<?= htmlspecialchars($imagen); ?>" 
                     alt="<?= htmlspecialchars($prod['nombre_producto']); ?>" 
                     class="card-img-top" style="height:150px; object-fit:contain;">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title"><?= htmlspecialchars($prod['nombre_producto']); ?></h6>
                    <p class="text-muted mb-1"><?= htmlspecialchars($prod['categoria'] ?? 'Sin categoría'); ?></p>
                    <p class="mb-1">Cantidad: <strong><?= intval($prod['cantidad']); ?></strong></p>
                    <p class="mb-1">Precio unitario: $<?= number_format($prod['precio_unitario'], 2, ',', '.'); ?></p>
                    <p class="fw-bold mt-auto">Subtotal: $<?= number_format($subtotal, 2, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="mt-4 text-end fs-5 fw-bold">
    Total de la compra: $<?= number_format($compra->getTotal(), 2, ',', '.'); ?>
</div>
