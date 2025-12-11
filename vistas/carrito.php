<?php
require_once("functions/autoload.php");

Carrito::iniciar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? null;
    $id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : null;

    if ($accion === 'agregar' && $id) {
        Carrito::agregarProducto($id);
    } elseif ($accion === 'eliminar' && $id) {
        Carrito::eliminarProducto($id);
    } elseif ($accion === 'vaciar') {
        Carrito::vaciar();
    }
}

$productos_en_carrito = Carrito::obtenerProductos();
$total = Carrito::obtenerTotal();
?>

<div class="container my-5">
    <h2><i class="fa-solid fa-cart-shopping mx-2"></i>
Carrito</h2>

    <?php if (empty($productos_en_carrito)): ?>
        <p>No hay productos en el carrito.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio por unidad</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos_en_carrito as $item): ?>
                    <tr>
                        <td class="d-flex align-items-center">
                            <img src="assets/imagenes/prods/<?= htmlspecialchars($item['producto']->getImagen()) ?>"
                                alt="<?= htmlspecialchars($item['producto']->getNombre()) ?>"
                                style="width: 50px; height: 50px; object-fit: contain; margin-right: 10px;">
                            <?= htmlspecialchars($item['producto']->getNombre()) ?>
                        </td>
                        <td><?= $item['cantidad'] ?></td>
                        <td>$<?= number_format($item['producto']->getPrecio(), 2, ',', '.') ?></td>
                        <td>$<?= number_format($item['producto']->getPrecio() * $item['cantidad'], 2, ',', '.') ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="producto_id" value="<?= $item['producto']->getId() ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <button type="submit" class="btn btn-danger btn-xl"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td colspan="2"><strong>$<?= number_format($total, 2, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>


        <div class="d-flex gap-3">
            <form method="POST" class="m-0">
                <input type="hidden" name="accion" value="vaciar">
                <button type="submit" class="btn btn-danger text-white py-3 px-5">Vaciar carrito</button>
            </form>

            <?php if (isset($_SESSION['loggedIn'])): ?>

                <!-- Si está logueado botón normal -->
                <form action="index.php?sec=compra-form" method="POST" class="m-0">
                    <?php foreach ($productos_en_carrito as $item): ?>
                        <input type="hidden" name="carrito[<?= $item['producto']->getId() ?>]" value="<?= $item['cantidad'] ?>">
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-success text-white py-3 px-5">
                        <i class="fa-solid fa-credit-card mx-2"></i> Ir a pagar
                    </button>
                </form>

            <?php else: ?>

                <!-- Si no está logueados, mensaje -->
                <div class="alert alert-warning">
                    Debes <a href="index.php?sec=login">iniciar sesión</a> para poder realizar la compra.
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>