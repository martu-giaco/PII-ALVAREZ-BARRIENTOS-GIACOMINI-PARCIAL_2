<?php
require_once __DIR__ . '/../../functions/autoload.php';

$postData = $_POST;

if (empty(trim($postData['categoria']))) {
    die("El nombre de la categoría es obligatorio.");
}

$id = $_POST['id_categoria'] ?? null;
$nombre = $_POST['categoria'] ?? '';

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

try {
    Categoria::edit(
        (int) $postData['id_categoria'], 
        trim($postData['categoria']),
        $imagen
    );

    Alerta::add_alerta("success", "Se editó correctamente la categoría: " . $postData['nombre'] . " (ID: " . $postData['id'] . ")");
    
} catch (Exception $e) {
    die("No se pudo editar la categoría: " . $e->getMessage());
}

header('Location: ../index.php?sec=categorias');
exit;
