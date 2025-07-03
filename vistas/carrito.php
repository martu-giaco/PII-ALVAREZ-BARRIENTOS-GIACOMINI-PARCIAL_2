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

<div class="container container-carrito my-5">
    <h2 class="mb-4">Tu Carrito</h2>


        <p>No hay productos en el carrito.</p>
        <a href="index.php?sec=productos" class="btn btn-dark text-white py-3 px-4">Volver a productos</a>

</div>
