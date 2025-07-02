<?php
session_start();
require_once __DIR__ . '/classes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    $usuarioLogueado = Usuario::autenticar($usuario, $password);

    if ($usuarioLogueado) {
        if ($usuarioLogueado->getRol() === 'admin') {
            header('Location: panel.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<div class="container d-flex justify-content-center">
        <div class="login-container">
            <h3 class="mb-4 text-center">Iniciar sesión</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger text-center">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
            </form>

            <div class="mt-3 text-center">
                <small>¿No tenés cuenta? Contactá al administrador.</small>
            </div>
        </div>
    </div>
<!-- Formulario HTML aquí con un <form method="post"> -->
