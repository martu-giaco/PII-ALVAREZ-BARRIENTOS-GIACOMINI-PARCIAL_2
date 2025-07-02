<?php
require_once("../../functions/autoload.php");

$postData = $_POST;
$login = Autenticacion::log_in($postData['usuario'], $postData['clave']);
if($login){
    if($login == "usuario"){
    header("location: ../index.php?sec=login");
        // header("location: ../../index.php");
    }else{
        header("location: ../index.php?sec=inicio");
    }
}else{
    header("location: ../index.php?sec=login");
}

echo "<pre>";
print_r($_SESSION);
echo "</pre>";

?>