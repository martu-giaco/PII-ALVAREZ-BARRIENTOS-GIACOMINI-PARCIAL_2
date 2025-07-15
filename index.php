<?php


// Bootstrap CSS y JS CDN
$cssBootstrap = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">';
$jsBootstrap = '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>';

require_once "functions/autoload.php";
// Carga clase para manejar secciones
require_once "classes/secciones.php";

// Secciones válidas (todas las vistas disponibles)
$secciones_validas = Secciones::secciones_validas();

// Secciones que aparecen en el menú
$secciones_menu = Secciones::secciones_menu();

// Ver qué sección se está pidiendo en la URL (por ejemplo: ?sec=productos)
$seccion = $_GET['sec'] ?? 'inicio';

// Si la sección NO es válida, cargar 404
if (!in_array($seccion, $secciones_validas)) {
    $vista = '404';
} else {
    $vista = $seccion;
}

// Obtener el título de la sección actual desde el JSON
$secciones = Secciones::secciones_del_sitio();
$title_seccion = "";
foreach ($secciones as $s) {
    if ($s->getVinculo() === $vista) {
        $title_seccion = $s->getTitle();
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<?php require_once "modulos/head.php"; ?>

<body>
    <div class="apple-p2">
        <?php require_once "modulos/navbar.php"; ?>

        <main class="container py-4">
            <?php require_once "vistas/$vista.php"; ?>
        </main>

        <?php require_once "modulos/footer.php"; ?>
    </div>

</body>

</html>