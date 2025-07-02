<?php
require_once("../../functions/autoload.php");


$postData = $_POST;

echo "<pre>";
print_r($postData);
echo "</pre>";


try{
    Categoria::insert(
        $postData['categoria']
    );
}catch (Exception $e){
    die("No se pudo cargar la categoria.");
}


?>