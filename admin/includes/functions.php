<?php
/**
 * Función que retorna un array con las secciones que pueden ser visitadas en el sitio
 */
function secciones_validas(){
    $secciones = ["inicio", "productos", "categorias", "usuarios", "niveles", "provincias",
    "crear_categoria", "editar_categoria", "borrar_categoria", "borrar_categoria_acc", 
    "crear_producto", "editar_producto", "borrar_producto", "borrar_producto_acc", 
    "login", "logout" ];
    return $secciones;
}

/**
 * Función que retorna un array con las secciones que aparecen en el menu principal
 */
function secciones_menu(){
    $secciones = ["inicio", "productos", "categorias"];
    $secciones = secciones_menu_log($secciones);
    return $secciones;
}

function secciones_menu_log($sec){
    if(isset($_SESSION['loggedIn'])){
        $sec[] = "logout";
        $sec[] = "Hola ".$_SESSION['loggedIn']['nombre'];
    }else{
        $sec[] = "login";
    }
    return $sec;
}

?>