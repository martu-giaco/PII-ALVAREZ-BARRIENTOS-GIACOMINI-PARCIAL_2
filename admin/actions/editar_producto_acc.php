<?php
require_once __DIR__ . '/../../functions/autoload.php';

$postData = $_POST;
$datosArchivo = $_FILES['foto'];

try {
    $producto = Producto::get_x_id(intval($postData['id_producto']));

    if (!$producto) {
        throw new Exception("Producto no encontrado.");
    }

    // Subida de imagen nueva si corresponde
    if (!empty($datosArchivo['tmp_name'])) {
        // desactivar imagen anterior
        Imagen::desactivarImagen("../../img/productos/" . $producto->getImagen());
        // Subir nueva imagen
        $imagen = Imagen::subirImagen("../../img/productos", $datosArchivo);
    } else {
        // Mantener imagen original
        $imagen = $postData['imagen_og'];
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
