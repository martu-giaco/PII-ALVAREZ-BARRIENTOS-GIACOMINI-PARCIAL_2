<?php
require_once __DIR__ . '/../../functions/autoload.php';

$postData = $_POST;

try {
    Categoria::insert(
        $postData['categoria']
    );

    Alerta::add_alerta("success", "Se creó correctamente la categoría: " . $postData['nombre'] . " (ID: " . $postData['id'] . ")");

} catch (Exception $e) {
    die("No se pudo cargar la categoría: " . $e->getMessage());
}

header('Location: ../index.php?sec=categorias');
exit;
