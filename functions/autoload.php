<?php
session_start();

spl_autoload_register('autoloadClasses');

function autoloadClasses($nombreClase){

    
    $archivoClase = __DIR__ . "/../classes/$nombreClase.php";
    

    if(file_exists($archivoClase)){
        require_once($archivoClase);
    }else{
        die("No se pudo cargar la clase: $nombreClase");
    }
}
?>