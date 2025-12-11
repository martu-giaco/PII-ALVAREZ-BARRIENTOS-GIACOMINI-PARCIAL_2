<?php
require_once __DIR__ . '/../../functions/autoload.php';

Autenticacion::verify(true); 

$id = $_POST['id_compra'] ?? null;
$estado = $_POST['estado'] ?? null;

if (!$id || !$estado) {
    Alerta::add_alerta('warning', 'Datos incompletos.');
    header('Location: ../index.php?sec=compras');
    exit;
}

$compra = Compra::getPorId($id);
if (!$compra) {
    Alerta::add_alerta('danger', 'Compra no encontrada.');
    header('Location: ../index.php?sec=compras');
    exit;
}

// Actualizar estado
$compra->setEstado($estado);

Alerta::add_alerta('success', 'Compra actualizada correctamente.');
header('Location: ../index.php?sec=compras');
exit;
