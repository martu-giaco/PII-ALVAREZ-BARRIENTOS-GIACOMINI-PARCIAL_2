<?php
require_once("../../functions/autoload.php");

try {
    //Obtiene el ID del producto desde la URL (GET) y carga el objeto Producto correspondiente
    $producto = Producto::get_x_id($_GET['id']);

    //Llama al método activar() del producto, que cambia su estado 'activo' a 1 en la base de datos
    $producto->activar();

    //Agrega una alerta de éxito para mostrar en la vista
    Alerta::add_alerta("success", "Producto reactivado correctamente.");
} catch (Exception $e) {
    //Si ocurre algún error, se agrega una alerta de error
    Alerta::add_alerta("danger", "Error al reactivar el producto.");

    //Se muestra el mensaje técnico del error como información secundaria (útil para debug)
    Alerta::add_alerta("secondary", $e->getMessage());
}

//Redirige al usuario nuevamente al listado de productos (panel de administración)
header("Location: ../index.php?sec=productos");