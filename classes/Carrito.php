<?php
require_once __DIR__ . '/Producto.php';

class Carrito
{
    public static function iniciar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    public static function agregarProducto(int $producto_id): void
    {
        self::iniciar();
        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]++;
        } else {
            $_SESSION['carrito'][$producto_id] = 1;
        }
    }

    public static function eliminarProducto(int $producto_id): void
    {
        self::iniciar();
        unset($_SESSION['carrito'][$producto_id]);
    }

    public static function vaciar(): void
    {
        self::iniciar();
        $_SESSION['carrito'] = [];
    }

    public static function obtenerCarrito(): array
    {
        self::iniciar();
        return $_SESSION['carrito'];
    }

    public static function obtenerProductos(): array
    {
        self::iniciar();
        $productos = [];

        foreach ($_SESSION['carrito'] as $id => $cantidad) {
            $producto = Producto::get_x_id($id);
            if ($producto) {
                $productos[] = ['producto' => $producto, 'cantidad' => $cantidad];
            }
        }

        return $productos;
    }

    public static function obtenerTotal(): float
    {
        $total = 0;
        foreach (self::obtenerProductos() as $item) {
            $total += $item['producto']->getPrecio() * $item['cantidad'];
        }
        return $total;
    }
}
