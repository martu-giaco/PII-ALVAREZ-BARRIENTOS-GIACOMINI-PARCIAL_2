<?php
$cssBootstrap = '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">';
$jsBootstrap = '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>';
?>

<?php
    
    require_once "classes/secciones.php";
    $secciones_validas = Secciones::secciones_validas();
    
    $secciones_menu = Secciones::secciones_menu();
    
    $seccion = isset($_GET['sec']) ? $_GET['sec'] : 'inicio';
    if(!in_array($seccion, $secciones_validas)){
        $vista = '404';
    }else{
        $vista = $seccion;
    }
    
    $secciones = Secciones::secciones_del_sitio();
    $title_seccion = "";
    foreach ($secciones as $value) {
        if($value->getVinculo() == $vista){
            $title_seccion = $value->getTitle();
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
    <?php
    require_once "modulos/head.php";
    ?>
<body>
    <?php
        require_once "modulos/navbar.php";
    ?>
    <main>
    <?php 
        require_once "vistas/$vista.php";
    ?>
    </main>
    <?php
        require_once "modulos/footer.php";
    ?>
</body>
</html>