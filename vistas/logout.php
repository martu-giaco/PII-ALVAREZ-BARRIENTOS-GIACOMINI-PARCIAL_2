<?php
require_once __DIR__ . '/../functions/autoload.php';
session_start();

if (isset($_SESSION['loggedIn'])) {
    unset($_SESSION['loggedIn']);
}

// Redirigir al login
header("Location: ../index.php?sec=login");
exit;
?>

<section class="d-flex align-items-center justify-content-center h-100">
    <div class="text-center border rounded p-5 shadow" style="max-width: 400px; width: 100%;">
        <h1 class="mb-4 text-dark">¿Cerrar sesión?</h1>
        <p class="mb-4 text-secondary">Estás conectado como <strong><?= htmlspecialchars($_SESSION['loggedIn']['usuario']) ?></strong>.</p>

            <div class="d-flex w-100 justify-content-between g-3">
                <form action="admin/actions/logout.php" method="post">
                    <button type="submit" class="btn btn-dark py-3 px-5 fw-semibold">Confirmar</button>
                </form>

                <a href="?sec=inicio" class="btn btn-light py-3 px-5">Cancelar</a>
            </div>
    </div>
</section>
