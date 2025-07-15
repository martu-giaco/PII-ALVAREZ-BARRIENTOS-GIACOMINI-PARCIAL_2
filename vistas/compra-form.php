<?php
// compra-form.php
require_once(__DIR__ . '/../functions/autoload.php');


// Recibir carrito enviado por POST
$carrito = $_POST['carrito'] ?? [];

?>

<div class="container py-5">
    <h1 class="mb-4">Finalizar compra</h1>

    <?php if (empty($carrito)): ?>
        <p>No hay productos en el carrito para comprar.</p>
        <a href="index.php?sec=productos" class="btn btn-dark">Volver a productos</a>
    <?php else: ?>
        <form action="index.php?sec=compra" method="POST" class="row g-3">
            <?php foreach ($carrito as $id => $cantidad): ?>
                <input type="hidden" name="carrito[<?= intval($id) ?>]" value="<?= intval($cantidad) ?>">
            <?php endforeach; ?>

            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="col-12">
                <label for="direccion" class="form-label">Dirección de envío</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>

            <div class="col-12">
                <label class="form-label">Método de pago</label>
                <select class="form-select" name="metodo_pago" required>
                    <option value="tarjeta">Tarjeta de crédito/débito</option>
                    <option value="mercado_pago">Mercado Pago</option>
                    <option value="efectivo">Efectivo</option>
                </select>
            </div>

            <div class="col-12 d-flex gap-3">
                <button type="submit" class="btn btn-success py-3 px-5 my-2">
                    <i class="fa-solid fa-credit-card mx-2"></i>Finalizar compra
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>
