<?php
require_once __DIR__ . '/../../functions/autoload.php';
require_once __DIR__ . '/functions.php'; // Asegurarte que functions.php se cargue primero

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) session_start();

// Obtener usuario y rol de manera segura
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

                    <!-- Mostrar usuario y rol si existe sesión -->
                    <?php if ($usuario && $rol): ?>
                        <li class="nav-item d-flex align-items-center me-3">
                            <span class="me-2"><?= htmlspecialchars($usuario) ?></span>
                            <span class="badge <?= mb_strtolower($rol) === 'admin' ? 'bg-danger' : 'bg-primary' ?> text-white">
                                <?= htmlspecialchars($rol) ?>
                            </span>
                        </li>
                    <?php endif; ?>

                    <!-- Menú dinámico desde functions.php -->
                    <?php foreach (secciones_menu() as $vinculo => $texto): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?sec=<?= htmlspecialchars($vinculo); ?>">
                                <?= $texto /* Mantener iconos HTML */ ?>
                            </a>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>
    </nav>
</header>
