<?php require_once __DIR__ . '/../../functions/autoload.php'; 
require_once __DIR__ . '/../../classes/Alerta.php';
?>

<section class="container">
    <form action="actions/login.php" method="post">
        <h1 class="h3 mb-3 fw-normal">Iniciar Sesión</h1>

        <?= Alerta::get_alertas(); ?>

        <div class="form-floating m-3">
            <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
            <label>Nombre de usuario o email</label>
        </div>

        <div class="form-floating m-3">
            <input type="password" name="clave" class="form-control" placeholder="Clave" required>
            <label>Clave</label>
        </div>

        <input type="submit" value="Login" class="btn btn-primary w-100 py-2 m-3">
    </form>
</section>
