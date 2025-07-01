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

    // Métodos para obtener los datos (Getters)
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

    /**
     * 🔄 MÉTODO ESTÁTICO: cargarProductosConCategorias
     * Carga todos los productos de la base de datos y les asigna sus categorías relacionadas.
     */
    public static function cargarProductosConCategorias(): array
    {
        // Conexión a la base de datos
        $conexion = (new Conexion())->getConexion();

        // Traer todos los productos
        $query = "SELECT * FROM productos";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute();
        $productosData = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);

        $productos = [];

        // Por cada producto, buscamos sus categorías relacionadas
        foreach ($productosData as $fila) {
            $queryCat = "
                SELECT c.id, c.nombre 
                FROM categorias c
                JOIN producto_categoria pc ON c.id = pc.categoria_id
                WHERE pc.producto_id = :producto_id
            ";
            $PDOStatementCat = $conexion->prepare($queryCat);
            $PDOStatementCat->execute(['producto_id' => $fila['id']]);
            $categorias = $PDOStatementCat->fetchAll(PDO::FETCH_ASSOC);

            // Creamos un objeto Producto con los datos y categorías
            $productos[] = new Producto(
                $fila['id'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['precio'],
                $categorias,
                $fila['imagen']
            );
        }

        return $productos;
    }

    /**
     * MÉTODO ESTÁTICO: cargarPorId
     * Busca un solo producto por su ID y carga sus categorías.
     */public static function get_x_id(int $id): ?Producto
    {
        $conexion = (new Conexion())->getConexion();

        // Obtener producto con ese ID
        $query = "SELECT * FROM productos WHERE id = :id";
        $stmt = $conexion->prepare($query);
        $stmt->execute(['id' => $id]);
        $productoData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$productoData) {
            return null; // No existe producto con ese ID
        }

        // Obtener categorías asociadas
        $queryCategorias = "
        SELECT c.id, c.nombre 
        FROM categorias c
        JOIN producto_categoria pc ON c.id = pc.categoria_id
        WHERE pc.producto_id = :producto_id
    ";
        $stmtCategorias = $conexion->prepare($queryCategorias);
        $stmtCategorias->execute(['producto_id' => $id]);
        $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

        // Crear y devolver instancia de Producto
        return new Producto(
            $productoData['id'],
            $productoData['nombre'],
            $productoData['descripcion'],
            $productoData['precio'],
            $categorias,
            $productoData['imagen']
        );
    }


    /**
     * 🖼 MÉTODO: getRutaImagen
     * Genera la ruta a la imagen del producto según la categoría.
     */
    public function getRutaImagen()
    {
        $formatos = ['png', 'jpg', 'jpeg', 'webp'];

        // Si no tiene categorías, mostrar imagen por defecto
        if (empty($this->categorias)) {
            return "assets/imagenes/prods/default.jpg";
        }

        // Usamos el nombre de la primera categoría
        $categoriaNombre = $this->categorias[0]['nombre'] ?? null;

        if (!$categoriaNombre) {
            return "assets/imagenes/prods/default.jpg";
        }

        // Armamos el nombre de archivo
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

        // Si no encuentra ninguna imagen válida
        return "assets/imagenes/prods/default.jpg";
    }
}
