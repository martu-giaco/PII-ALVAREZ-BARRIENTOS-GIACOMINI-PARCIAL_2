<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: contacto.php");
    exit;
}

$nombre = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$email = $_POST['email'] ?? '';
$comentario = $_POST['comentario'] ?? '';
?>

<div class="container my-5">
    <div class="alert alert-success text-center" role="alert">
        ¡Gracias por contactarte con nosotros, <?= htmlspecialchars($nombre) ?>! Tu formulario fue enviado con éxito. Nos comunicaremos a la brevedad.
    </div>

    <div class="card mt-4 mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <h5 class="card-title">Resumen de tu mensaje:</h5>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($nombre) ?> <?= htmlspecialchars($apellido) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Comentario:</strong><br><?= nl2br(htmlspecialchars($comentario)) ?></p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary">Volver al inicio</a>
    </div>
</div>