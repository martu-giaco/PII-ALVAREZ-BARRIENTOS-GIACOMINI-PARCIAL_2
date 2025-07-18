<?php
require_once __DIR__ . '/../../functions/autoload.php';

$postData = $_POST;

try {
    // Validaciones básicas
    if (empty($postData['usuario']) || empty($postData['email']) || empty($postData['clave']) || empty($postData['rol'])) {
        throw new Exception("Faltan datos obligatorios.");
    }


    $id_usuario = Usuario::insert(
        trim($postData['usuario']),
        trim($postData['email']),
        trim($postData['clave']),
        trim($postData['rol'])
    );

    echo $id_usuario;

    header('Location: ../index.php?sec=usuarios');
} catch (Exception $e) {
    die("No se pudo cargar el usuario. Error: " . $e->getMessage());
}
