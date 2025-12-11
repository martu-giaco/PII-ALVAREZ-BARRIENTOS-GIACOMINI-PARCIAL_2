<?php
require_once __DIR__ . '/../../functions/autoload.php';
Autenticacion::verify(true);

$postData = $_POST;

// Validar nombre de categoría
$nombre = trim($postData['categoria'] ?? '');
if ($nombre === '') {
    die("El nombre de la categoría es obligatorio.");
}

// Obtener ID
$id = $postData['id_categoria'] ?? null;
if (!$id) {
    die("ID de categoría no proporcionado.");
}

// Manejo de imagen: valor por defecto es la imagen original
$imagen = $_POST['imagen_og'] ?? null;

// Verificar si se subió un archivo nuevo
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . "/../../assets/imagenes/categorias-fotitos/";
    $originalName = $_FILES['foto']['name'];
    $filename = basename($originalName);
    $target = $uploadDir . $filename;

    // Evitar sobrescribir archivos existentes
    $i = 1;
    while (file_exists($target)) {
        $filename = pathinfo($originalName, PATHINFO_FILENAME) . "_$i." . pathinfo($originalName, PATHINFO_EXTENSION);
        $target = $uploadDir . $filename;
        $i++;
    }

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
        $imagen = $filename; // actualizar imagen solo si se subió correctamente
    }
}

// Validar que tengamos una imagen antes de guardar en BD
if (!$imagen) {
    die("No se pudo determinar la imagen de la categoría.");
}

// Editar categoría
try {
    Categoria::edit(
        (int)$id,
        $nombre,
        $imagen
    );

    Alerta::add_alerta("success", "Se editó correctamente la categoría: " . htmlspecialchars($nombre) . " (ID: " . $id . ")");
} catch (Exception $e) {
    die("No se pudo editar la categoría: " . $e->getMessage());
}

// Redirigir al listado de categorías
header('Location: ../index.php?sec=categorias');
exit;
