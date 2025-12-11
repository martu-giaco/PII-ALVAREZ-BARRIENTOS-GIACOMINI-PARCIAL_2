<?php
require_once __DIR__ . '/Conexion.php';

class Compra
{
    private $id_compra;
    private $id_usuario;
    private $nombre_cliente;
    private $email;
    private $direccion;
    private $metodo_pago;
    private $total;
    private $fecha;
    private $estado;
    private $detalles = [];

    public function __construct($id_compra, $id_usuario, $nombre_cliente, $email, $direccion, $metodo_pago, $total, $fecha, $estado)
    {
        $this->id_compra = $id_compra;
        $this->id_usuario = $id_usuario;
        $this->nombre_cliente = $nombre_cliente;
        $this->email = $email;
        $this->direccion = $direccion;
        $this->metodo_pago = $metodo_pago;
        $this->total = $total;
        $this->fecha = $fecha;
        $this->estado = $estado;
    }

    // Getters
    public function getId()
    {
        return $this->id_compra;
    }
    public function getUsuario()
    {
        return $this->id_usuario;
    }

    public function getProductos()
    {
        return $this->productos ?? [];
    }

    public function getNombreCliente()
    {
        return $this->nombre_cliente;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    public function getMetodoPago()
    {
        return $this->metodo_pago;
    }
    public function getTotal()
    {
        return $this->total;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function getImagenProducto(array $producto): string
{
    return 'assets/imagenes/prods/' . ($producto['imagen_ruta'] ?? 'default.png');
}




    public function setEstado($estado)
    {
        $this->estado = $estado;
        $db = (new Conexion())->getConexion();
        $stmt = $db->prepare("UPDATE compras SET estado = :estado WHERE id_compra = :id");
        $stmt->execute(['estado' => $estado, 'id' => $this->id_compra]);
    }

    public function eliminar()
    {
        $db = (new Conexion())->getConexion();
        $stmt = $db->prepare("DELETE FROM compras WHERE id_compra = :id");
        return $stmt->execute(['id' => $this->id_compra]);
    }

    // Obtener compra por ID
    public static function getPorId($id)
    {
        $db = (new Conexion())->getConexion();
        $stmt = $db->prepare("SELECT * FROM compras WHERE id_compra = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Compra(
                $data['id_compra'],
                $data['id_usuario'],
                $data['nombre_cliente'],
                $data['email'],
                $data['direccion'],
                $data['metodo_pago'],
                $data['total'],
                $data['fecha'],
                $data['estado']
            );
        }
        return null;
    }

    // Obtener todas las compras (para admin)
    public static function obtenerTodas()
    {
        $db = (new Conexion())->getConexion();
        $stmt = $db->query("SELECT * FROM compras ORDER BY fecha DESC");
        $compras = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $compras[] = new Compra(
                $data['id_compra'],
                $data['id_usuario'],
                $data['nombre_cliente'],
                $data['email'],
                $data['direccion'],
                $data['metodo_pago'],
                $data['total'],
                $data['fecha'],
                $data['estado']
            );
        }
        return $compras;
    }

    // Obtener compras de un usuario específico
    public static function obtenerPorUsuario($id_usuario)
    {
        $db = (new Conexion())->getConexion();
        $stmt = $db->prepare("SELECT * FROM compras WHERE id_usuario = :id_usuario ORDER BY fecha DESC");
        $stmt->execute(['id_usuario' => $id_usuario]);
        $compras = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $compras[] = new Compra(
                $data['id_compra'],
                $data['id_usuario'],
                $data['nombre_cliente'],
                $data['email'],
                $data['direccion'],
                $data['metodo_pago'],
                $data['total'],
                $data['fecha'],
                $data['estado']
            );
        }
        return $compras;
    }

    // Cargar detalles de la compra (productos + categoría)
public function cargarDetalles(): void
{
    $db = (new Conexion())->getConexion();

    // Consulta incluyendo categoría
    $stmt = $db->prepare("
        SELECT 
            p.nombre AS nombre_producto,
            c.nombre AS categoria,
            cd.cantidad,
            cd.precio_unitario,
            p.imagen AS imagen_ruta
        FROM compra_detalle cd
        JOIN productos p ON cd.id_producto = p.id
        LEFT JOIN categorias c ON cd.id_categoria = c.id
        WHERE cd.id_compra = :id_compra
    ");

    $stmt->execute(['id_compra' => $this->id_compra]);

    // Guardamos en la propiedad detalles
    $this->detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Getter para los detalles
public function getDetalles(): array
{
    return $this->detalles ?? [];
}

}
