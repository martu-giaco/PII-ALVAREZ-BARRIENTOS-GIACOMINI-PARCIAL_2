<?php
require_once __DIR__ . '/../classes/Producto.php';

$accion = $_POST['accion'] ?? null;
$producto_id = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : null;
$carrito = $_POST['carrito'] ?? [];

if ($accion === 'agregar' && $producto_id) {
    if (isset($carrito[$producto_id])) {
        $carrito[$producto_id]++;
    } else {
        $carrito[$producto_id] = 1;
    }
}

function formatoPrecio($num) {
    return number_format($num, 2, ',', '.');
}
?>

<div class="container py-5">
    <h1 class="mb-4"><i class="fa-solid fa-cart-shopping mx-3"></i>Carrito</h1>

    <?php if (empty($carrito)): ?>
        <p>No hay productos en el carrito.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categorías</th>
                    <th>Precio por unidad</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($carrito as $id_str => $cantidad_raw):
                    $id = (int)$id_str;
                    $cantidad = (int)$cantidad_raw;
                    $producto = Producto::get_x_id($id);
                    if (!$producto) continue;

                    $subtotal = $producto->getPrecio() * $cantidad;
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($producto->getNombre()) ?></td>
                        <td>
                            <?php foreach ($producto->getCategorias() as $cat): ?>
                                <span class="badge bg-secondary"><?= htmlspecialchars($cat['nombre']) ?></span>
                            <?php endforeach; ?>
                        </td>
                        <td>$<?= formatoPrecio($producto->getPrecio()) ?></td>
                        <td><?= $cantidad ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="fw-bold">
                    <td colspan="4" class="text-end">Total:</td>
                    <td>$<?= formatoPrecio($total) ?></td>
                </tr>
            </tbody>
        </table>

        <form action="index.php?sec=compra-form" method="post" class="d-inline-block">
            <?php foreach ($carrito as $id => $cantidad): ?>
                <input type="hidden" name="carrito[<?= (int)$id ?>]" value="<?= (int)$cantidad ?>">
            <?php endforeach; ?>
            <button type="submit" class="btn btn-success py-3 px-5">
                <i class="fa-solid fa-credit-card"></i> Ir a pagar
            </button>
        </form>
    <?php endif; ?>
</div>
