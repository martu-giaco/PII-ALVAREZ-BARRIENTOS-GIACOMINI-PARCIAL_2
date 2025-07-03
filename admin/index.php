<?php

// Bootstrap CSS y JS CDN
$cssBootstrap = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">';
$jsBootstrap = '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>';


require_once("../classes/Conexion.php");
require_once("includes/functions.php");

$seccion = isset($_GET['sec']) ? $_GET['sec'] : 'inicio';
if (!in_array($seccion, secciones_validas())) {
    $vista = '404';
    $title_seccion = "Error 404 - Página no encontrada";

} else {
    $vista = $seccion;
    $title_seccion = ucfirst(strtolower($seccion)) . " - Portal de Administración";
}

?>



<!DOCTYPE html>
<html lang="es">
<?php require_once "includes/head.php"; ?>

<body>
    <div class="apple-p2">
        <?php require_once "includes/navbar.php"; ?>

        <main class="container container-fluid py-4">
            <?php require_once "vistas/$vista.php"; ?>
        </main>

        <?php require_once "includes/footer.php"; ?>
    </div>

</body>

</html>