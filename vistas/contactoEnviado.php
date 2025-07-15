<?php
if (
    !isset($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['comentario']) ||
    empty($_POST['nombre']) ||
    empty($_POST['apellido']) ||
    empty($_POST['email']) ||
    empty($_POST['comentario'])
) {
    // Redirigir al formulario de contacto si faltan datos
    header('Location: index.php?sec=contacto');
    exit;
}
// Sanitizar datos para mostrar
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$comentario = $_POST['comentario'];
?>

<div class="container-contacto container-fluid py-5">
    <h2 class="text-center mb-4">Gracias por contactarnos!</h2>
        <p><?= $nombre ?> <?= $apellido ?></p>
        <p><strong>Email:</strong> <?= $email ?></p>
        <p><strong>Comentario:</strong></p>
        <p><?= $comentario?></p>
    </div>
</div>
