<?php
// compra.php

require_once(__DIR__ . '/../functions/autoload.php');

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirigir si no viene por POST o carrito vacío
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['carrito'])) {
    header('Location: index.php?sec=compra-form');
    exit;
}

// Recibir datos del formulario
$carrito     = $_POST['carrito'] ?? [];
$nombre      = trim($_POST['nombre'] ?? '');
$email       = trim($_POST['email'] ?? '');
$direccion   = trim($_POST['direccion'] ?? '');
$metodo_pago = trim($_POST['metodo_pago'] ?? '');

// Validar campos obligatorios
if (!$nombre || !$email || !$direccion || !$metodo_pago) {
    echo '<div class="container py-5">';
    echo '<p class="text-danger">Faltan datos obligatorios. Por favor completa el formulario.</p>';
    echo '<a href="index.php?sec=compra-form" class="btn btn-primary">Volver al formulario</a>';
    echo '</div>';
    exit;
}

// Calcular total
$total = 0;
foreach ($carrito as $id => $cantidad) {
    $producto = Producto::get_x_id(intval($id));
    if ($producto) {
        $total += $producto->getPrecio() * $cantidad;
    }
}

// Insertar la compra en la base de datos
try {
    $conexion = (new Conexion())->getConexion();

    // Insertar en tabla compras
    $stmt = $conexion->prepare("
        INSERT INTO compras (id_usuario, nombre_cliente, email, direccion, metodo_pago, total)
        VALUES (:id_usuario, :nombre, :email, :direccion, :metodo_pago, :total)
    ");
    $stmt->execute([
        'id_usuario'   => $_SESSION['loggedIn']['id_usuario'] ?? null,
        'nombre'       => $nombre,
        'email'        => $email,
        'direccion'    => $direccion,
        'metodo_pago'  => $metodo_pago,
        'total'        => $total
    ]);

    $id_compra = $conexion->lastInsertId();

    // Insertar detalle de productos
    foreach ($carrito as $id => $cantidad) {
        $producto = Producto::get_x_id(intval($id));
        if (!$producto) continue;

        // Obtener categoría principal del producto
        $stmt_cat = $conexion->prepare("SELECT categoria_id FROM producto_categoria WHERE producto_id = :id LIMIT 1");
        $stmt_cat->execute(['id' => $id]);
        $categoria_id = $stmt_cat->fetchColumn() ?: null;

        $stmt_detalle = $conexion->prepare("
            INSERT INTO compra_detalle (id_compra, id_producto, id_categoria, cantidad, precio_unitario)
            VALUES (:id_compra, :id_producto, :id_categoria, :cantidad, :precio)
        ");
        $stmt_detalle->execute([
            'id_compra'    => $id_compra,
            'id_producto'  => $id,
            'id_categoria' => $categoria_id,
            'cantidad'     => $cantidad,
            'precio'       => $producto->getPrecio()
        ]);
    }

} catch (PDOException $e) {
    echo '<div class="container py-5">';
    echo '<p class="text-danger">Error al procesar la compra: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<a href="index.php?sec=compra-form" class="btn btn-primary">Volver al formulario</a>';
    echo '</div>';
    exit;
}

// Mostrar resumen de la compra
$metodos = [
    'tarjeta'      => 'Tarjeta de crédito/débito',
    'mercado_pago' => 'Mercado Pago',
    'efectivo'     => 'Efectivo contra entrega'
];
?>

<div class="container py-5">
    <h1 class="mb-4">Resumen de la compra</h1>

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
    <a href="index.php?sec=productos" class="btn btn-primary mt-3">Volver a productos</a>
</div>
