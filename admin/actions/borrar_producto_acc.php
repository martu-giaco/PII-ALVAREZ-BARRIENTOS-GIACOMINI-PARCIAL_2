<?php
require_once __DIR__ . '/../../functions/autoload.php';

$id = $_GET['id'] ?? false;

if (!$id) {
    die("ID de producto no válido.");
}

try {
    $producto = Producto::get_x_id($id);

    if (!$producto) {
        die("Producto no encontrado.");
    }

    // Marcamos como inactivo en vez de eliminar físicamente
    $producto->marcarComoInactivo();

} catch (Exception $e) {
    die("No se pudo borrar el producto: " . $e->getMessage());
}

header('Location: ../index.php?sec=productos');
exit;
