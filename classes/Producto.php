<?php
require_once 'Conexion.php';

class Producto
{
    private $id;
    private $nombre;
    private $presentacion;
    private $precio;
    private $foto;
    private $categorias = [];

    // Getters
    public function getId() { return $this->id; }
    public function getNombre() { return $this->nombre; }
    public function getPresentacion() { return $this->presentacion; }
    public function getPrecio() { return $this->precio; }
    public function getFoto() { return $this->foto; }
    public function getCategorias() { return $this->categorias; }

    // Obtener todos los productos con categorías cargadas
    public static function todosProductosCompletos(): array
    {
        $conexion = (new Conexion())->getConexion();
        $stmt = $conexion->prepare("SELECT * FROM productos");
        $stmt->execute();

        $productos = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $producto = new self();
            $producto->asignarDatosDesdeArray($fila);
            $producto->cargarCategorias();
            $productos[] = $producto;
        }
        return $productos;
    }

    // Obtener productos filtrados por categoría con categorías cargadas
    public static function productosPorCategoriaCompletos(string $categoriaNombre): array
    {
        $conexion = (new Conexion())->getConexion();
        $stmt = $conexion->prepare("
            SELECT p.*
            FROM productos p
            JOIN producto_categoria pc ON p.id = pc.producto_id
            JOIN categorias c ON c.id = pc.categoria_id
            WHERE c.nombre = :nombre
        ");
        $stmt->execute(['nombre' => $categoriaNombre]);

        $productos = [];
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $producto = new self();
            $producto->asignarDatosDesdeArray($fila);
            $producto->cargarCategorias();
            $productos[] = $producto;
        }
        return $productos;
    }

    // Obtener un producto por su ID, con categorías cargadas
    public static function get_x_id(int $id): ?self
    {
        $conexion = (new Conexion())->getConexion();
        $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fila) {
            return null;
        }

        $producto = new self();
        $producto->asignarDatosDesdeArray($fila);
        $producto->cargarCategorias();

        return $producto;
    }

    // Método privado para asignar propiedades desde array
    private function asignarDatosDesdeArray(array $datos): void
    {
        $this->id = $datos['id'] ?? null;
        $this->nombre = $datos['nombre'] ?? '';
        $this->presentacion = $datos['descripcion'] ?? '';
        $this->precio = $datos['precio'] ?? 0;
        $this->foto = $datos['imagen'] ?? '';
    }

    // Carga las categorías asociadas al producto
    public function cargarCategorias(): void
    {
        if (!$this->id) {
            $this->categorias = [];
            return;
        }

        $conexion = (new Conexion())->getConexion();
        $stmtCat = $conexion->prepare("
            SELECT c.id, c.nombre
            FROM categorias c
            JOIN producto_categoria pc ON c.id = pc.categoria_id
            WHERE pc.producto_id = :id
        ");
        $stmtCat->execute(['id' => $this->id]);
        $this->categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);
    }

    // Devuelve la ruta para la imagen del producto según su primera categoría
    public function getRutaImagen(): string
    {
        $categoria = 'default';
        if (!empty($this->categorias)) {
            $categoria = strtolower(str_replace(' ', '', trim($this->categorias[0]['nombre'])));
        }

        $archivo = $this->foto ?: 'default.png';
        if (!preg_match('/\.(png|jpg|jpeg|gif)$/i', $archivo)) {
            $archivo .= '.png';
        }

        return "assets/imagenes/prods/{$categoria}/{$archivo}";
    }
}
