<?php
require_once __DIR__ . '/../classes/secciones.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$secciones = Secciones::secciones_del_sitio();
$usuario = $_SESSION['loggedIn']['usuario'] ?? $_SESSION['loggedIn']['email'] ?? null;
$rol     = $_SESSION['loggedIn']['rol'] ?? null;
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand" href="?sec=inicio">
                <img src="assets/imagenes/Apple_logo_black.svg" alt="apple-logo" style="height: 30px;">
            </a>

            <!-- Botón hamburguesa -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">

                    <?php foreach ($secciones as $sec): 
                        $vinculo = $sec->getVinculo();
                        $mostrar = $sec->getInMenu();

                        if ($vinculo === "login" && !empty($_SESSION['loggedIn'])) continue;
                        if ($vinculo === "logout" && empty($_SESSION['loggedIn'])) continue;
                    ?>
                        <?php if ($mostrar): ?>
                            <li class="nav-item me-2">
                                <?php if ($vinculo === "logout"): ?>
                                    <a class="btn btn-danger rounded-pill text-white" href="?sec=logout">
                                        <?= $sec->getTexto() ?>
                                    </a>
                                <?php else: ?>
                                    <a class="nav-link" href="?sec=<?= htmlspecialchars($vinculo) ?>">
                                        <?= $sec->getTexto() ?>
                                    </a>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($usuario && $rol): ?>
                        <li class="nav-item d-flex align-items-center ms-3">
                            <span class="me-2"><?= htmlspecialchars($usuario) ?></span>
                            <span class="badge <?= mb_strtolower($rol) === 'admin' ? 'bg-danger' : 'bg-primary' ?> text-white">
                                <?= htmlspecialchars($rol) ?>
                            </span>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
</header>
