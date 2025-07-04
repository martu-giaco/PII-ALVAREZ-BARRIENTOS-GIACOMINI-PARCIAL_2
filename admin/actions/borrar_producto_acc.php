<?php
require_once("../../functions/autoload.php");

try {
    //Obtiene el producto a partir del ID recibido por GET
    $producto = Producto::get_x_id($_GET['id']);

    //Llama al método darBaja() que marca el producto como inactivo (activo = 0)
    $producto->darBaja();

    //Agrega una alerta de éxito para mostrar que la operación fue exitosa
    Alerta::add_alerta("success", "Producto dado de baja correctamente.");
} catch (Exception $e) {
    //por si hay algun problemita, agrega una alerta de error
    Alerta::add_alerta("danger", "Error al dar de baja el producto.");

    //Muestra el mensaje del error técnico como alerta secundaria
    Alerta::add_alerta("secondary", $e->getMessage());
}

//Redirige al panel de productos (listado general)
header("Location: ../index.php?sec=productos");