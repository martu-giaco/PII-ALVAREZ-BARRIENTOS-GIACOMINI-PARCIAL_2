<?php
require_once __DIR__ . '/../classes/Conexion.php';
require_once __DIR__ . '/../classes/Producto.php';

// Inicializar carrito
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Si llega POST con producto, agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_id'])) {
    $id = (int)$_POST['agregar_id'];
    $producto = Producto::get_x_id($id);

    if ($producto) {
        if (!isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id] = [
                'producto' => $producto,
                'cantidad' => 1
            ];
        } else {
            $_SESSION['carrito'][$id]['cantidad']++;
        }
    }

    // Redirigir para evitar reenviar formulario
    header("Location: carrito.php");
    exit;
}

// Si se hizo clic en 'proceder al pago'
$compraRealizada = isset($_GET['compra']) && $_GET['compra'] === 'ok';

// Vaciar el carrito si se realizó la compra
if ($compraRealizada) {
    $_SESSION['carrito'] = [];
}
?>


<div class="container">
    <h1 class="mb-4"><i class="fa-solid fa-cart-shopping me-2"></i>Carrito de Compras</h1>

    <?php if (empty($_SESSION['carrito'])): ?>
        <div class="alert alert-info">El carrito está vacío.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Producto</th>
                    <th>Precio unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['carrito'] as $item):
                    $producto = $item['producto'];
                    $cantidad = $item['cantidad'];
                    $subtotal = $producto->getPrecio() * $cantidad;
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($producto->getNombre()); ?></td>
                        <td>$<?= number_format($producto->getPrecio(), 2, ',', '.'); ?></td>
                        <td><?= $cantidad ?></td>
                        <td>$<?= number_format($subtotal, 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total</td>
                    <td class="fw-bold">$<?= number_format($total, 2, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>

        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCompra">
            <i class="fa-solid fa-credit-card me-1"></i> Proceder al pago
        </button>
    <?php endif; ?>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalCompra" tabindex="-1" aria-labelledby="modalCompraLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalCompraLabel">¡Compra realizada!</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        Tu compra ha sido procesada con éxito. Gracias por elegirnos.
      </div>
      <div class="modal-footer">
        <a href="carrito.php?compra=ok" class="btn btn-primary">Aceptar</a>
      </div>
    </div>
  </div>
</div>


