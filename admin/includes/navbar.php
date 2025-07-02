<?php
require_once __DIR__ . '/../classes/secciones.php';
$secciones = Secciones::secciones_del_sitio();
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand" href="?sec=inicio">
                <img src="assets/imagenes/Apple_logo_black.svg" alt="apple-logo" style="height: 30px;">
            </a>

            <!-- Botón hamburguesa para collapse -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú colapsable -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php foreach ($secciones as $value): ?>
                        <?php if ($value->getInMenu()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="?sec=<?= $value->getVinculo(); ?>">
                                    <?= $value->getTexto(); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
