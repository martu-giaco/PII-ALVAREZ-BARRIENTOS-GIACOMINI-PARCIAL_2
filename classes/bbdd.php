<?php

require_once __DIR__ . 'Conexion.php';

function obtenerTodosLosProductos(): array {
    $conexion = new Conexion();
    $db = $conexion->getConexion();

    $PDOStatement = $db->query("SELECT * FROM productos");
    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}
?>