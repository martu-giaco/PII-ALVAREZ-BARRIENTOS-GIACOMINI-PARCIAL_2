<?php
require_once __DIR__ . '/../functions/autoload.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Guardar datos del usuario para mostrar antes de cerrar sesión
$usuario = $_SESSION['loggedIn']['usuario'] ?? null;
$rol     = $_SESSION['loggedIn']['rol'] ?? null;
?>

<section class="d-flex align-items-center justify-content-center h-100">
    <div class="text-center border rounded p-5 shadow" style="max-width: 400px; width: 100%;">
        <h1 class="mb-4 text-dark">¿Cerrar sesión?</h1>

        <?php if ($usuario): ?>
            <p class="mb-4 text-secondary">
                Estás conectado como <strong><?= htmlspecialchars($usuario) ?></strong>
                <span class="badge <?= mb_strtolower($rol) === 'admin' ? 'bg-danger' : 'bg-primary' ?> text-white">
                    <?= htmlspecialchars($rol) ?>
                </span>
            </p>
        <?php endif; ?>

        <div class="d-flex w-100 justify-content-between g-3">
            <!-- Ajustar la ruta al archivo de acción real -->
            <form action="admin/actions/logout.php" method="post">
                <button type="submit" class="btn btn-dark py-3 px-5 fw-semibold">Confirmar</button>
            </form>
            <a href="?sec=inicio" class="btn btn-light py-3 px-5">Cancelar</a>
        </div>
    </div>
</section>
