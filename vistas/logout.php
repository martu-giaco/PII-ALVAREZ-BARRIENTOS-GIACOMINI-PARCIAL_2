<?php
require_once('functions/autoload.php');

// Redirige si no hay sesión activa
if (!isset($_SESSION['loggedIn'])) {
    header("Location: ../vistas/login.php");
    exit;
}
?>

<section class="container">
    <form action="../actions/logout.php" method="post" enctype="multipart/form-data">
        <h1 class="h3 mb-3 fw-normal">Cerrar Sesión</h1>
        
        <div class="form-floating m-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="Usuario" name="usuario" 
                value="<?= htmlspecialchars($_SESSION['loggedIn']['usuario']) ?>" readonly>
            <label for="floatingInput">Nombre de usuario</label>
        </div>

        <p class="text-center">¿Quieres cerrar sesión?</p>

        <input type="submit" value="Logout" class="btn btn-primary w-100 py-2 m-3">
        <a href="?sec=inicio" class="btn btn-danger w-100">Cancelar</a>
    </form>
</section>
