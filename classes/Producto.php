<?php
require_once __DIR__ . '/Conexion.php';

class Producto
{
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categorias = [];

    public function __construct($id, $nombre, $descripcion, $precio, $categorias = [])
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->categorias = $categorias;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getCategorias()
    {
        return $this->categorias;
    }

    public function getRutaImagen(): string
    {
        $formatos = ['png', 'jpg', 'jpeg', 'webp'];

        if (empty($this->categorias)) {
            return "assets/imagenes/prods/default.jpg";
        }

        $producto = strtolower(str_replace(' ', '-', $this->nombre)); // genera: "airpods-pro-2"
        $categoria = strtolower(str_replace(' ', '-', $this->categorias[0]['nombre']));
        $base = "{$categoria}_{$producto}"; // genera: "airpod_airpods-pro-2"

        $dir = __DIR__ . "/../assets/imagenes/prods/{$categoria}/";

        foreach ($formatos as $ext) {
            $archivo = "{$base}.{$ext}";
            if (file_exists($dir . $archivo)) {
                return "assets/imagenes/prods/{$categoria}/{$archivo}";
            }
        }

        return "assets/imagenes/prods/default.jpg";
    }

    public function getImagenes(): array
    {
        $imagenes = [];
        $formatos = ['png', 'jpg', 'jpeg', 'webp'];

        if (empty($this->categorias)) {
            return [['ruta' => 'default.png']];
        }

        $categoria = strtolower(str_replace(' ', '-', $this->categorias[0]['nombre']));
        $producto = strtolower(str_replace(' ', '-', $this->nombre));
        $base = "{$categoria}_{$producto}";
        $dir = __DIR__ . "/../assets/imagenes/prods/{$categoria}/";

        for ($i = 0; $i <= 5; $i++) {
            $nombreArchivo = $i === 0 ? $base : "{$base}_{$i}";

            foreach ($formatos as $ext) {
                $archivo = "{$nombreArchivo}.{$ext}";
                $rutaCompleta = $dir . $archivo;

                if (file_exists($rutaCompleta)) {
                    $imagenes[] = ['ruta' => "{$categoria}/{$archivo}"];
                    break;
                }
            }
        }

        if (empty($imagenes)) {
            $imagenes[] = ['ruta' => 'default.png'];
        }

        return $imagenes;
    }

    public static function get_x_id(int $id): ?Producto
    {
        $conexion = new Conexion();
        $db = $conexion->getConexion();

        $stmt = $db->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$datos)
            return null;

        $stmtCat = $db->prepare("
            SELECT c.nombre 
            FROM categorias c
            JOIN producto_categoria pc ON c.id = pc.categoria_id
            WHERE pc.producto_id = :id
        ");
        $stmtCat->execute(['id' => $id]);
        $categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

        return new Producto(
            $datos['id'],
            $datos['nombre'],
            $datos['descripcion'],
            $datos['precio'],
            $categorias
        );
    }

    public static function todosProductosCompletos(): array
    {
        $conexion = new Conexion();
        $db = $conexion->getConexion();

        $stmt = $db->query("SELECT id FROM productos");
        $productos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productos[] = self::get_x_id((int) $row['id']);
        }
        return $productos;
    }

    public static function productosPorCategoriaCompletos(string $categoriaNombre): array
    {
        $conexion = new Conexion();
        $db = $conexion->getConexion();

        $stmt = $db->prepare("
            SELECT p.id
            FROM productos p
            JOIN producto_categoria pc ON p.id = pc.producto_id
            JOIN categorias c ON pc.categoria_id = c.id
            WHERE c.nombre = :nombre
        ");
        $stmt->execute(['nombre' => $categoriaNombre]);

        $productos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productos[] = self::get_x_id((int) $row['id']);
        }
        return $productos;
    }
}
