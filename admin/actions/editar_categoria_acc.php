<?php
require_once("../../functions/autoload.php");


$postData = $_POST;
$categoria = Categoria::get_x_id($postData["id_categoria"]);

echo "<pre>";
print_r($postData);
echo "</pre>";

echo "<pre>";
print_r($categoria);
echo "</pre>";


try{
    $categoria->edit(
        $postData['categoria']
    );
}catch (Exception $e){
    die("No se pudo editar la categoria.");
}

header('Location: ../index.php?sec=categorias');

?>