<?php

require_once __DIR__ . 'Conexion.php';

function obtenerTodosLosProductos(): array {
    $conexion = new Conexion();
    $db = $conexion->getConexion();

    $stmt = $db->query("SELECT * FROM productos");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>