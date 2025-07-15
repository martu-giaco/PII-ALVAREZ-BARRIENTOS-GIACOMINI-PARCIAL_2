<?php
// compra.php

require_once __DIR__ . '/../functions/autoload.php';

$carrito = $_POST['carrito'] ?? [];
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$metodo_pago = $_POST['metodo_pago'] ?? '';

$metodos = [
    'tarjeta' => 'Tarjeta de crédito/débito',
    'mercado_pago' => 'Mercado Pago',
    'efectivo' => 'Efectivo contra entrega'
];

// Calcular total
$total = 0;
foreach ($carrito as $id => $cantidad) {
    $producto = Producto::get_x_id(intval($id));
    if ($producto) {
        $total += $producto->getPrecio() * $cantidad;
    }
}
?>

<div class="container py-5">
    <h1 class="mb-4">Resumen de la compra</h1>

    <?php if (empty($carrito) || !$nombre || !$email || !$direccion || !$metodo_pago): ?>
        <p class="text-danger">Faltan datos o el carrito está vacío. Por favor vuelve al formulario.</p>
        <a href="index.php?sec=compra-form" class="btn btn-primary">Volver al formulario</a>
    <?php else: ?>
        <ul>
            <li><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?></li>
            <li><strong>Email:</strong> <?= htmlspecialchars($email) ?></li>
            <li><strong>Dirección:</strong> <?= htmlspecialchars($direccion) ?></li>
            <li><strong>Método de pago:</strong> <?= $metodos[$metodo_pago] ?? 'No especificado' ?></li>
        </ul>

        <h3 class="my-4">Productos comprados</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrito as $id => $cantidad):
                    $producto = Producto::get_x_id(intval($id));
                    if (!$producto) continue;
                    $subtotal = $producto->getPrecio() * $cantidad;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($producto->getNombre()) ?></td>
                        <td><?= intval($cantidad) ?></td>
                        <td>$<?= number_format($producto->getPrecio(), 2, ',', '.') ?></td>
                        <td>$<?= number_format($subtotal, 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="fw-bold">
                    <td colspan="3" class="text-end">Total:</td>
                    <td>$<?= number_format($total, 2, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <p class="fs-5 mt-4">¡Gracias por tu compra!</p>
    <?php endif; ?>
</div>
