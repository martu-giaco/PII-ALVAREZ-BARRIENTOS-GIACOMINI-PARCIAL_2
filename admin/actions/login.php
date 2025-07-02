<?php
session_start();
require_once __DIR__ . '/../../classes/Usuario.php';
require_once __DIR__ . '/../../classes/Alerta.php';

$usuarioInput = $_POST['usuario'] ?? '';
$claveInput = $_POST['clave'] ?? '';

if (!$usuarioInput || !$claveInput) {
    Alerta::add_alerta('danger', 'Debe ingresar usuario y clave.');
    header('Location: ../login.php');
    exit;
}

$usuario = Usuario::obtenerPorUsuarioEmail($usuarioInput);

if (!$usuario) {
    Alerta::add_alerta('danger', 'El usuario no existe.');
    header('Location: ../vistas/login.php');
    exit;
}

if (!password_verify($claveInput, $usuario->getClave())) {
    Alerta::add_alerta('danger', 'La clave ingresada no es correcta.');
    header('Location: ../login.php');
    exit;
}

// Login exitoso
$_SESSION['loggedIn'] = [
    'id_usuario' => $usuario->getIdUsuario(),
    'usuario' => $usuario->getUsuario(),
    'email' => $usuario->getEmail(),
    'rol' => $usuario->getRol(),
];

header('Location: ../index.php?sec=inicio');
exit;
