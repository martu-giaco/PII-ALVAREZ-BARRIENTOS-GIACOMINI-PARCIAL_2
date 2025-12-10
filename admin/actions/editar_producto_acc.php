<?php
require_once __DIR__ . '/../../functions/autoload.php';

$postData = $_POST;

try {
    $producto = Producto::get_x_id(intval($postData['id_producto']));

    if (!$producto) {
        throw new Exception("Producto no encontrado.");
    }

// Determine image: handle uploaded file or fall back to original hidden field
$imagen = null;
if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
	// simple upload handling (adjust target dir/name as needed)
	$uploadDir = __DIR__ . "/../../assets/imagenes/categorias-fotitos/";
	$filename = basename($_FILES['foto']['name']);
	$target = $uploadDir . $filename;
	if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
		$imagen = $filename;
	} else {
		// upload failed: optionally set $imagen = $_POST['imagen_og'] or null
		$imagen = $_POST['imagen_og'] ?? null;
	}
} else {
	$imagen = $_POST['imagen_og'] ?? null;
}

    // Ejecutar método de edición
    $producto->edit(
        intval($postData['id_categoria']),
        $postData['nombre'],
        $postData['presentacion'],
        floatval($postData['precio']),
        $imagen
    );

    Alerta::add_alerta("success", "Se editó correctamente el producto: " . $postData['nombre'] . " (ID: " . $postData['id_producto'] . ")");

} catch (Exception $e) {
    Alerta::add_alerta("warning", "Hubo un problema al editar el producto.");
    Alerta::add_alerta("secondary", $e->getMessage());
}

header('Location: ../index.php?sec=productos');
