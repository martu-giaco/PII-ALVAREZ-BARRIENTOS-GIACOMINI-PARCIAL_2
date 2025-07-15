<?php
require_once("../functions/autoload.php");

/**
 * Secciones válidas para seguridad
 */
function secciones_validas(): array
{
    return Secciones::secciones_validas();
}

/**
 * Secciones visibles en el menú del panel admin
 */
function secciones_menu(): array
{
    $menu = [];

    // Secciones permitidas en el menú admin
    $permitidas = ["inicio", "productos", "categorias", "login", "logout"];

    foreach (Secciones::secciones_del_sitio() as $seccion) {
        $vinculo = $seccion->getVinculo();
        $mostrar = $seccion->getInMenu();

        if (!in_array($vinculo, $permitidas))
            continue;

        // Ocultar login si hay sesión activa
        if ($vinculo === 'login' && isset($_SESSION['loggedIn']))
            continue;

        // Ocultar logout si NO hay sesión
        if ($vinculo === 'logout' && !isset($_SESSION['loggedIn']))
            continue;

        if ($mostrar) {
            $menu[$vinculo] = $seccion->getTexto();
        }

    }

    return $menu;
}

?>