<?php
// Incluir autoload para cargar clases automáticamente
require_once(__DIR__ . '/../functions/autoload.php');



?>

<section class="container">
    <form action="admin/actions/login.php" method="post" enctype="multipart/form-data">
        <h1 class="h3 mb-3 fw-normal">Iniciar sesión</h1>

        <!-- Mostrar alertas si existen -->
        <div>
            <?php echo Alerta::get_alertas(); ?>
        </div>

        <!-- Campo para el nombre de usuario o email -->
        <div class="form-floating m-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="Usuario" name="usuario" required>
            <label for="floatingInput">Nombre de usuario</label>
        </div>

        <!-- Campo para la clave -->
        <div class="form-floating m-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Clave" name="clave" required>
            <label for="floatingPassword">Clave</label>
        </div>

        <!-- Botón de login -->
        <input type="submit" value="Login" class="btn btn-primary px-5 py-3 m-3">
    </form>
</section>
