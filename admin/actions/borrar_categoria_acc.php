<?php
require_once("../../functions/autoload.php");



$id = $_GET['id'] ?? FALSE;
echo "<pre>";
print_r($id);
echo "</pre>";

try{
    $categoria = Categoria::get_x_id($id);

    echo "<pre>";
    print_r($categoria);
    echo "</pre>";

    $categoria->delete();
}catch (Exception $e){
    die("No se pudo borrar la categoria.");
}

header('Location: ../index.php?sec=categorias');

?>