<?php
    require_once "classes/secciones.php";
    $secciones = Secciones::secciones_del_sitio();
?>

<h1 class="titulo">Apple</h1>

<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <a class="navbar-brand" href="?seccion=inicio">
                        <img src="assets/imagenes/Apple_logo_black.svg" alt="apple-logo">
                    </a>
                <?php
                foreach ($secciones as $value) {
                    if($value->getInMenu()){
                ?>
                    <li class="nav-item">
                        <a  class="nav-link" href="?sec=<?= $value->getVinculo(); ?>"><?= $value->getTexto(); ?></a>
                    </li>
                <?php
                }
                }
                ?>
                </ul>
            </div>
        </div>
    </nav>
</header>