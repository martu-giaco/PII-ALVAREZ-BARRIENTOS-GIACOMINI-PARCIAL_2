<?php
require_once("../../functions/autoload.php");

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
    $categoria->marcarComoInactiva();

} catch (Exception $e) {
    die("No se pudo borrar la categoría: " . $e->getMessage());
}

header('Location: ../index.php?sec=categorias');
exit;
