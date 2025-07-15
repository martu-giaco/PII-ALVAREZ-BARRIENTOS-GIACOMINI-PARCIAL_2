<?php
require_once __DIR__ . '../functions/autoload.php';

$postData = $_POST;
$datosArchivo = $_FILES['foto'] ?? null;

try {
    // Validaciones básicas
    if (empty($postData['id_categoria']) || empty($postData['nombre']) || empty($postData['presentacion']) || empty($postData['precio'])) {
        throw new Exception("Faltan datos obligatorios.");
    }

    // Subir imagen, si no hay archivo o hubo error, usar imagen por defecto
    if ($datosArchivo && $datosArchivo['error'] === UPLOAD_ERR_OK) {
        $imagen = Imagen::subirImagen("../../img/productos", $datosArchivo);
    } else {
        $imagen = 'default.jpg'; // o '' según lo que uses por defecto
    }

    $idProducto = Producto::insert(
        (int)$postData['id_categoria'], 
        trim($postData['nombre']),
        trim($postData['presentacion']),
        (float)$postData['precio'],
        $imagen
    );

    echo $idProducto;

    header('Location: ../index.php?sec=productos');
} catch (Exception $e) {
    die("No se pudo cargar el producto. Error: " . $e->getMessage());
}
