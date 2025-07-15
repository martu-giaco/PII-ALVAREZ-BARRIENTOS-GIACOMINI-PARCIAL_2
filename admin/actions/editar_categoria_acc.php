<?php
require_once __DIR__ . '/../../functions/autoload.php';

$postData = $_POST;

if (empty(trim($postData['categoria']))) {
    die("El nombre de la categoría es obligatorio.");
}

try {
    Categoria::edit(
        (int) $postData['id_categoria'], 
        trim($postData['categoria'])
    );
} catch (Exception $e) {
    die("No se pudo editar la categoría: " . $e->getMessage());
}

header('Location: ../index.php?sec=categorias');
exit;
