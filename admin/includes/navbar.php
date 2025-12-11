<?php
require_once __DIR__ . '/../../functions/autoload.php';
require_once __DIR__ . '/functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();

$usuario = $_SESSION['loggedIn']['usuario'] ?? $_SESSION['loggedIn']['email'] ?? null;
$rol     = $_SESSION['loggedIn']['rol'] ?? null;
?>

<header class="container-fluid">
    <nav class="navbar navbar-expand-sm bg-body-tertiary">
        <div class="container justify-content-between">

            <!-- Logo -->
            <a class="navbar-brand" href="?sec=inicio">
                <img src="../assets/imagenes/Apple_logo_black.svg" alt="apple-logo" style="height: 30px;">
            </a>

            <!-- Botón hamburguesa -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">

                    <!-- Menú dinámico -->
                    <?php foreach (secciones_menu() as $vinculo => $texto): ?>
                        <?php
                        // Ocultar login/logout según sesión
                        if ($vinculo === "login" && !empty($_SESSION['loggedIn'])) continue;
                        if ($vinculo === "logout" && empty($_SESSION['loggedIn'])) continue;
                        ?>
                        <li class="nav-item me-2">
                            <?php if ($vinculo === "logout"): ?>
                                <a class="btn btn-danger rounded-pill text-white" href="?sec=logout">
                                    <?= $texto ?>
                                </a>
                            <?php else: ?>
                                <a class="nav-link" href="?sec=<?= htmlspecialchars($vinculo); ?>">
                                    <?= $texto ?>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>

                    <!-- Usuario y rol -->
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
