<?php
require_once __DIR__ . '/../../functions/autoload.php';

try {
    //Obtiene el ID del usuario desde la URL (GET) y carga el objeto usuario correspondiente
    $usuario = Usuario::get_x_id($_GET['id_usuario']);

    //Llama al método activar() del usuario, que cambia su estado 'activo' a 1 en la base de datos
    $usuario->activar();

    //Agrega una alerta de éxito para mostrar en la vista
    Alerta::add_alerta("success", "Usuario reactivado.");
} catch (Exception $e) {
    //Si ocurre algún error, se agrega una alerta de error
    Alerta::add_alerta("danger", "No fue posible reactivar el usuario.");

    //Se muestra el mensaje técnico del error como información secundaria (útil para debug)
    Alerta::add_alerta("secondary", $e->getMessage());
}

//Redirige al usuario nuevamente al listado de usuarios (panel de administración)
header("Location: ../index.php?sec=usuarios");