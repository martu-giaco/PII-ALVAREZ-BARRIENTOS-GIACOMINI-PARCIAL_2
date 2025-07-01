<?php
require_once __DIR__ . '/Conexion.php';

class Producto
{
    private $id;
    private $imagen;
    private $nombre;
    private $descripcion;
    private $precio;
    private $categorias = [];

    public function __construct($id = null, $nombre = null, $descripcion = null, $precio = null, $categorias = [], $imagen = null)
    {
        $this->id = $id;
        $this->imagen = $imagen;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->categorias = $categorias;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getImagen()
    {
        return $this->imagen;
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

    // Método para cargar productos con categorías
    public static function cargarProductosConCategorias(): array
    {
        $conexion = (new Conexion())->getConexion();

        $PDOStatement = $conexion->prepare("SELECT * FROM productos");
        $PDOStatement->execute();
        $productosData = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

        $productos = [];

        foreach ($productosData as $fila) {
            $PDOStatementCat = $conexion->prepare("
                SELECT c.id, c.nombre 
                FROM categorias c
                JOIN producto_categoria pc ON c.id = pc.categoria_id
                WHERE pc.producto_id = :producto_id
            ");
            $PDOStatementCat->execute(['producto_id' => $fila['id']]);
            $categorias = $PDOStatementCat->fetchAll(PDO::FETCH_ASSOC);

            $productos[] = new Producto(
                $fila['id'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['precio'],
                $categorias
            );
        }

        return $productos;
    }

    public function getRutaImagen()
    {
        $formatos = ['png', 'jpg', 'jpeg', 'webp'];

        if (empty($this->categorias)) {
            return "assets/imagenes/prods/default.jpg";
        }

        // Tomo la primera categoría (debe ser array con 'nombre')
        $categoriaNombre = $this->categorias[0]['nombre'] ?? null;
        if (!$categoriaNombre) {
            return "assets/imagenes/prods/default.jpg";
        }

        $categoria = strtolower(str_replace(' ', '-', $categoriaNombre));
        $producto = strtolower(str_replace(' ', '-', $this->nombre));
        $base = "{$categoria}_{$producto}";

        $dir = __DIR__ . "/../assets/imagenes/prods/{$categoria}/";

        foreach ($formatos as $ext) {
            $archivo = "{$base}.{$ext}";
            if (file_exists($dir . $archivo)) {
                return "assets/imagenes/prods/{$categoria}/{$archivo}";
            }
        }

        // Si no encontró ninguna imagen, devuelve la default
        return "assets/imagenes/prods/default.jpg";
    }

    public static function cargarPorId(int $id): ?self
    {
        $conexion = (new Conexion())->getConexion();
        $query = "SELECT * FROM productos WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(['id' => $id]);
        $productoData = $PDOStatement->fetch(PDO::FETCH_ASSOC);

        if (!$productoData) {
            return null;
        }

        $query = "SELECT c.id, c.nombre 
                 FROM categorias c
                 JOIN producto_categoria pc ON c.id = pc.categoria_id
                 WHERE pc.producto_id = :producto_id";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(['producto_id' => $id]);
        $categorias = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

        return new self(
            $productoData['id'],
            $productoData['nombre'],
            $productoData['descripcion'],
            $productoData['precio'],
            $categorias
        );
    }




}
