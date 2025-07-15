<?php
require_once __DIR__ . '/../../functions/autoload.php';

$postData = $_POST;

try {
    Categoria::insert(
        $postData['categoria']
    );
} catch (Exception $e) {
    die("No se pudo cargar la categoría: " . $e->getMessage());
}

header('Location: ../index.php?sec=categorias');
exit;
