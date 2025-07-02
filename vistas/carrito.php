<?php
require_once __DIR__ . '/../classes/Producto.php';
require_once __DIR__ . '/../classes/Conexion.php';

// Recibir carrito actual (IDs y cantidades) y acción desde POST
$carrito = $_POST['carrito'] ?? [];
$accion = $_POST['accion'] ?? null;

if (!is_array($carrito)) {
    $carrito = [];
}

// Procesar acciones
if ($accion === 'agregar' && isset($_POST['producto_id'])) {
    $id = intval($_POST['producto_id']);
    if (isset($carrito[$id])) {
        $carrito[$id] = intval($carrito[$id]) + 1;
    } else {
        $carrito[$id] = 1;
    }
} elseif ($accion === 'eliminar' && isset($_POST['producto_id'])) {
    $id = intval($_POST['producto_id']);
    unset($carrito[$id]);
} elseif ($accion === 'vaciar') {
    $carrito = [];
}

// Cargar productos del carrito
$productos_en_carrito = [];
foreach ($carrito as $id => $cantidad) {
    $producto = Producto::cargarPorId($id);
    if ($producto) {
        $productos_en_carrito[] = ['producto' => $producto, 'cantidad' => $cantidad];
    }
}
?>

<div class="container my-5">
    <h2 class="mb-4">Tu Carrito</h2>

    <?php if (empty($productos_en_carrito)): ?>
        <p>No hay productos en el carrito.</p>
        <a href="index.php?sec=productos" class="btn btn-dark">Volver a productos</a>
    <?php else: ?>
        <form method="post" action="carrito.php">
            <?php foreach ($carrito as $id => $cantidad): ?>
                <input type="hidden" name="carrito[<?= intval($id) ?>]" value="<?= intval($cantidad) ?>">
            <?php endforeach; ?>

            <table class="table table-bordered text-white align-middle">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($productos_en_carrito as $item):
                        $producto = $item['producto'];
                        $cantidad = intval($item['cantidad']);
                        $subtotal = $producto->getPrecio() * $cantidad;
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= $producto->getNombre() ?></td>
                        <td>$<?= number_format($producto->getPrecio(), 2, ',', '.') ?></td>
                        <td><?= $cantidad ?></td>
                        <td>$<?= number_format($subtotal, 2, ',', '.') ?></td>
                        <td>
                            <button type="submit" 
                                name="accion" 
                                value="eliminar" 
                                class="btn btn-danger btn-sm" 
                                formaction="carrito.php"
                                formmethod="post"
                                onclick="this.form.producto_id.value='<?= $producto->getId() ?>'">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total</td>
                        <td colspan="2" class="fw-bold">$<?= number_format($total, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>

            <input type="hidden" name="producto_id" value="">
            <button type="submit" name="accion" value="vaciar" class="btn btn-warning">Vaciar carrito</button>
            <button type="submit" class="btn btn-success ms-3" formaction="#" formmethod="post">
                Ir a pagar <i class="bi bi-credit-card"></i>
            </button>
        </form>
    <?php endif; ?>
</div>
