<?php
session_start(); // Necesario para poder trabajar con $_SESSION

require_once("../../functions/autoload.php"); // Autoload para cargar clases como Usuario o Alerta

// Capturamos los datos del formulario
$usuarioInput = $_POST['usuario'] ?? '';
$claveInput = $_POST['clave'] ?? '';

// Validamos que se haya completado usuario y clave
if (!$usuarioInput || !$claveInput) {
    Alerta::add_alerta('danger', 'Debe ingresar usuario y clave.');
    header("Location: ../vistas/login.php");
    exit;
}

// Obtenemos el usuario desde la base de datos (por nombre de usuario o email)
$usuario = Usuario::obtenerPorUsuarioEmail($usuarioInput);

// Si el usuario no existe, redirigimos con mensaje
if (!$usuario) {
    Alerta::add_alerta('danger', 'El usuario no existe.');
    header("Location: ../vistas/login.php");
    exit;
}

// Obtenemos la clave que vino de la DB
$claveGuardada = $usuario->getClave();

// Verificamos si coincide la clave (acepta hash o texto plano si es prueba)
if (password_verify($claveInput, $claveGuardada) || $claveInput === $claveGuardada) {

    // Guardamos en sesión los datos del usuario
    $_SESSION['loggedIn'] = [
        'id_usuario' => $usuario->getIdUsuario(),
        'usuario'    => $usuario->getUsuario(),
        'email'      => $usuario->getEmail(),
        'rol'        => $usuario->getRol(), // "admin" o "cliente"
    ];

    // Redirigimos según su rol
    if ($usuario->getRol() === 'admin') {
        header("Location: ../index.php?sec=inicio"); // admin
    } else {
        header("Location: ../../index.php"); // cliente
    }
    exit;
} else {
    // Clave incorrecta
    Alerta::add_alerta('danger', 'La clave ingresada no es correcta.');
    header("Location: ../vistas/login.php");
    exit;
}
?>
