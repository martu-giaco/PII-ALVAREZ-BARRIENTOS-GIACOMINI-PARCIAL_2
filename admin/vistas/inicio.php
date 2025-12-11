<?php
require_once __DIR__ . '/../../functions/autoload.php';
Autenticacion::verify(true);
$usuario = $_SESSION['loggedIn']['usuario'] ?? $_SESSION['loggedIn']['email'] ?? 'Usuario';
?>

<div class="container h-50 py-5">
    
    <h2 class="mb-3">Bienvenido al panel de administración, <strong><?= htmlspecialchars($usuario) ?></strong>!</h2>
    <?= Alerta::get_alertas(); ?>

    <p class="mb-4">Gestionar usuarios, productos y categorías.</p>

    <!-- Accesos directos -->
    <div class="d-flex flex-wrap gap-3 mb-4">
        <a href="?sec=usuarios" class="btn btn-light border border-secondary py-3 px-4 shadow">
            <i class="fas fa-users me-2"></i> Gestionar Usuarios
        </a>
        <a href="?sec=productos" class="btn btn-light border border-secondary py-3 px-4 shadow">
            <i class="fas fa-boxes me-2"></i> Gestionar Productos
        </a>
        <a href="?sec=categorias" class="btn btn-light border border-secondary py-3 px-4 shadow">
            <i class="fas fa-tags me-2"></i> Gestionar Categorías
        </a>
    </div>

    <!-- Imagen decorativa -->
    <div class="text-start">
        <img src="https://media.giphy.com/media/v1.Y2lkPWVjZjA1ZTQ3aWFtZjg4c295Y3RhcHJlZXl1aXFqZmJ2N294Y2ZycGhtcnJodnptdSZlcD12MV9naWZzX3JlbGF0ZWQmY3Q9Zw/4a5b4AH9TG7zEgsEEe/giphy.gif" 
            class="img-fluid rounded shadow" 
            alt="GIF editar en admin">
    </div>
</div>
