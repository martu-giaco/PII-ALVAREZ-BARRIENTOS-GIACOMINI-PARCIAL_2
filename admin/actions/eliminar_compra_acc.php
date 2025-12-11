<?php
require_once __DIR__ . '/../../functions/autoload.php';

Autenticacion::verify(true);

$id_compra = $_POST['id_compra'] ?? null;

if (!$id_compra) {
    Alerta::add_alerta('error', 'Compra no encontrada.');
    header("Location: ../index.php?sec=compras");
    exit;
}

$compra = Compra::getPorId($id_compra);
if (!$compra) {
    Alerta::add_alerta('error', 'Compra no encontrada.');
    header("Location: ../index.php?sec=compras");
    exit;
}

if ($compra->eliminar()) {
    Alerta::add_alerta('success', 'Compra eliminada correctamente.');
} else {
    Alerta::add_alerta('error', 'No se pudo eliminar la compra.');
}

header("Location: ../index.php?sec=compras");
exit;
