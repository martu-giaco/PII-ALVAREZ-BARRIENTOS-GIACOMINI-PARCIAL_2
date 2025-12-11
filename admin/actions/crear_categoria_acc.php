<?php
require_once __DIR__ . '/../../functions/autoload.php';
Autenticacion::verify(true);

$postData = $_POST;

// Validar nombre
$nombre = trim($postData['categoria'] ?? '');
if ($nombre === '') die("El nombre de la categoría es obligatorio.");

// Manejo de imagen
$imagen = null;
if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . "/../../assets/imagenes/categorias-fotitos/";
    $filename = basename($_FILES['foto']['name']);

    // Evitar sobrescribir archivos
    $target = $uploadDir . $filename;
    $i = 1;
    while (file_exists($target)) {
        $filename = pathinfo($_FILES['foto']['name'], PATHINFO_FILENAME) . "_$i." . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $target = $uploadDir . $filename;
        $i++;
    }

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
        $imagen = null;
    } else {
        $imagen = $filename;
    }
}

// Insertar categoría usando el método existente
try {
    Categoria::insert($nombre, $imagen);
    Alerta::add_alerta("success", "Categoría '$nombre' creada correctamente.");
} catch (Exception $e) {
    die("No se pudo crear la categoría: " . $e->getMessage());
}

header('Location: ../index.php?sec=categorias');
exit;
