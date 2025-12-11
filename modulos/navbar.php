<?php
require_once __DIR__ . '/../classes/secciones.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$secciones = Secciones::secciones_del_sitio();
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand" href="?sec=inicio">
                <img src="assets/imagenes/Apple_logo_black.svg" alt="apple-logo" style="height: 30px;">
            </a>

            <!-- Botón hamburguesa para responsive -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Ítems del menú -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <!-- Mostrar email y rol si hay sesión -->
                    <?php if (isset($_SESSION['loggedIn'])): ?>
                        <li class="nav-item d-flex align-items-center me-3">
                            <span class="me-2">
                                <?= htmlspecialchars($_SESSION['loggedIn']['usuario']) ?>
                            </span>
                            <span class="badge 
                                <?= mb_strtolower($_SESSION['loggedIn']['rol']) === 'admin' ? 'bg-danger' : 'bg-primary' ?> 
                                text-white">
                                <?= htmlspecialchars($_SESSION['loggedIn']['rol']) ?>
                            </span>
                        </li>
                    <?php endif; ?>

                    <?php foreach ($secciones as $sec): ?>
                        <?php
                            $vinculo = $sec->getVinculo();
                            $mostrar = $sec->getInMenu();

                            // Ocultar "Iniciar sesión" si ya hay sesión
                            if ($vinculo === "login" && isset($_SESSION['loggedIn'])) continue;

                            // Ocultar "Cerrar sesión" si no hay sesión
                            if ($vinculo === "logout" && !isset($_SESSION['loggedIn'])) continue;
                        ?>

                        <?php if ($mostrar): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="?sec=<?= $vinculo ?>">
                                    <?= $sec->getTexto() ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </nav>
</header>
