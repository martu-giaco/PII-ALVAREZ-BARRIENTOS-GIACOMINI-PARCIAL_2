<?php
require_once("../../functions/autoload.php");

try {
    $categoria = Categoria::get_x_id($_GET['id']);
    if (!$categoria) {
        throw new Exception("Categoría no encontrada.");
    }

    if ($categoria->activar()) {
        Alerta::add_alerta("success", "Categoría reactivada correctamente.");
    } else {
        throw new Exception("No se pudo reactivar la categoría.");
    }
} catch (Exception $e) {
    Alerta::add_alerta("danger", "Error al reactivar la categoría.");
    Alerta::add_alerta("secondary", $e->getMessage());
}

header("Location: ../index.php?sec=categorias");
exit;
