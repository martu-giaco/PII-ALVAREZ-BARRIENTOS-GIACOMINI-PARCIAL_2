<?php
require_once("../../functions/autoload.php");

// Guardamos los datos del formulario en una variable
$postData = $_POST;
$datosArchivo = $_FILES['foto']; // Asegurate que el input type="file" tenga name="foto"

try {
    // Procesamos la imagen (si se subió)
    if (!empty($datosArchivo['tmp_name'])) {
        $imagen = Imagen::subirImagen("../../img/productos", $datosArchivo);
    } else {
        $imagen = null; // o podrías poner una imagen por defecto
    }

    // Insertamos el nuevo producto usando el método insert de la clase Producto
    Producto::insert(
        $postData['id_categoria'],
        $postData['nombre'],
        $postData['presentacion'], // o descripción
        $postData['precio'],
        $imagen
    );

    Alerta::add_alerta("success", "Producto creado correctamente.");
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Hubo un error al crear el producto.");
    Alerta::add_alerta("secondary", $e->getMessage());
}

// Redireccionamos al listado de productos
header("Location: ../index.php?sec=productos");
exit;