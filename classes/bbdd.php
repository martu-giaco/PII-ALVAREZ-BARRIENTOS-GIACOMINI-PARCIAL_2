<?php

require_once __DIR__ . 'Conexion.php';

function obtenerTodosLosProductos(): array {
    $conexion = new Conexion();
    $db = $conexion->getConexion();
    $query = "SELECT * FROM productos";
    $PDOStatement = $db->query($query);
    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}
?>