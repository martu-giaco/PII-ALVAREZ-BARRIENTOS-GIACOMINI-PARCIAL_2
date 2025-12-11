<?php
// compra-form.php
require_once(__DIR__ . '/../functions/autoload.php');

// Verificar que el usuario esté autenticado (no requiere admin)
Autenticacion::verify(false);

// Obtener el usuario logueado desde sesión
$usuarioSesion = $_SESSION['loggedIn'] ?? null;
$email = '';
if ($usuarioSesion && isset($usuarioSesion['id_usuario'])) {
    require_once __DIR__ . '/../classes/Usuario.php';
    $usuario = Usuario::get_x_id($usuarioSesion['id_usuario']);
    if ($usuario) {
        $email = $usuario->getEmail();
    }
}

// Recibir carrito enviado por POST
$carrito = $_POST['carrito'] ?? [];
?>

<div class="container py-5">
    <h1 class="mb-4">Finalizar compra</h1>

    <?php if (empty($carrito)): ?>
        <div class="alert alert-warning text-center">
            No hay productos en el carrito para comprar.
        </div>
        <div class="text-center mt-3">
            <a href="index.php?sec=productos" class="btn btn-dark btn-lg">Volver a Productos</a>
        </div>
    <?php else: ?>
        <form action="index.php?sec=compra" method="POST" class="row g-3 mx-auto">

            <?php foreach ($carrito as $id => $cantidad): ?>
                <input type="hidden" name="carrito[<?= intval($id) ?>]" value="<?= intval($cantidad) ?>">
            <?php endforeach; ?>

            <!-- Nombre completo editable -->
            <div class="col-12">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" required>
            </div>

            <!-- Email como texto y hidden -->
            <div class="col-12">
                <label class="form-label">Correo electrónico</label>
                <div class="form-control bg-light" style="cursor: not-allowed;"><?= htmlspecialchars($email); ?></div>
                <input type="hidden" name="email" value="<?= htmlspecialchars($email); ?>">
            </div>

            <!-- Dirección -->
            <div class="col-12">
                <label for="direccion" class="form-label">Dirección de envío</label>
                <input type="text" class="form-control form-control-lg" id="direccion" name="direccion" placeholder="Calle, número, ciudad, provincia" required>
            </div>

            <!-- Método de pago -->
            <div class="col-12">
                <label class="form-label">Método de pago</label>
                <select class="form-select form-select-lg" name="metodo_pago" required>
                    <option value="tarjeta">Tarjeta de crédito/débito</option>
                    <option value="mercado_pago">Mercado Pago</option>
                    <option value="efectivo">Efectivo</option>
                </select>
            </div>

            <!-- Botón de finalizar -->
            <div class="col-12 d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fa-solid fa-credit-card me-2"></i>Finalizar Compra
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>
