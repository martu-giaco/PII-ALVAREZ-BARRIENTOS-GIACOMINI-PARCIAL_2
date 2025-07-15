<?php
require_once __DIR__ . '/../../functions/autoload.php';
if (session_status() === PHP_SESSION_NONE) session_start();
require_once("../functions/autoload.php");
?>
<header class="container-fluid">
    <nav class="navbar navbar-expand-sm bg-body-tertiary">
        <div class="container justify-content-between">
            <a class="navbar-brand" href="?sec=inicio">
                <img src="../assets/imagenes/Apple_logo_black.svg" alt="apple-logo" style="height: 30px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <?php foreach (secciones_menu() as $vinculo => $texto): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?sec=<?= htmlspecialchars($vinculo); ?>">
                                <?= $texto /* texto con iconos sin alterar */ ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
