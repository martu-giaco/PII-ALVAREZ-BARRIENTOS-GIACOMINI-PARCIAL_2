if (
    !isset($_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['comentario']) ||
    empty(trim($_POST['nombre'])) ||
    empty(trim($_POST['apellido'])) ||
    empty(trim($_POST['email'])) ||
    empty(trim($_POST['comentario']))
) {
    // Si falta algún dato, redirigir al formulario de contacto
    header('Location: index.php?sec=contacto');
    exit;
}

// Sanitizar datos para mostrar
$nombre = htmlspecialchars(trim($_POST['nombre']));
$apellido = htmlspecialchars(trim($_POST['apellido']));
$email = htmlspecialchars(trim($_POST['email']));
$comentario = htmlspecialchars(trim($_POST['comentario']));
?>

<div class="container-contacto container-fluid py-5">
    <h1 class="text-center mb-4">Gracias por contactarnos, <?= $nombre ?>!</h1>
    <p class="text-center mb-3 fs-5">
        Hemos recibido tu consulta y nos pondremos en contacto a la brevedad a través del email: <strong><?= $email ?></strong>.
    </p>
    <div class="mb-5">
        <h4>Resumen de tu consulta:</h4>
        <p><strong>Nombre:</strong> <?= $nombre ?> <?= $apellido ?></p>
        <p><strong>Email:</strong> <?= $email ?></p>
        <p><strong>Comentario:</strong></p>
        <p><?= nl2br($comentario) ?></p>
    </div>
    <div class="text-center">
        <a href="index.php?sec=contacto" class="btn btn-primary">Volver al formulario</a>
    </div>
</div>