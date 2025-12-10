<?php
require_once __DIR__ . '/../../functions/autoload.php';

$id = $_GET['id'] ?? false;

if (!$id) {
    die("ID de categoría no válido.");
}

try {
    $categoria = Categoria::get_x_id($id);

    if (!$categoria) {
        die("Categoría no encontrada.");
    }

    // Marcamos la categoría como inactiva (en lugar de eliminar)
    $categoria->eliminarCategoria();

    Alerta::add_alerta("warning", "Se eliminó correctamente la categoría: " . $postData['nombre'] . " (ID: " . $postData['id'] . ")");

} catch (Exception $e) {
    die("No se pudo desactivar la categoría: " . $e->getMessage());
}

header('Location: ../index.php?sec=categorias');
exit;