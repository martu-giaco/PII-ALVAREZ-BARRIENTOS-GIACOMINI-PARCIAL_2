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
    public function getIdProducto()
    {
        return $this->id;
    }

    public function getIdCategoria()
    {
        return $this->id;
    }
    public function getCategoria()
    {
        return $this->categorias;
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
     * MÉTODO ESTÁTICO: cargarProductosConCategorias
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
     */
    public static function get_x_id(int $id): ?Producto
    {
        $conexion = (new Conexion())->getConexion();

        // Obtener producto con ese ID
        $query = "SELECT * FROM productos WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(['id' => $id]);
        $productoData = $PDOStatement->fetch(PDO::FETCH_ASSOC);

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
        $PDOStatementCategorias = $conexion->prepare($queryCategorias);
        $PDOStatementCategorias->execute(['producto_id' => $id]);
        $categorias = $PDOStatementCategorias->fetchAll(PDO::FETCH_ASSOC);

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
     * Obtiene todos los productos de la base de datos
     */
    public function todosProductos(): array
    {
        $conexion = (new Conexion())->getConexion();

        $query = "
    SELECT p.*, c.nombre AS categoria
    FROM productos p
    LEFT JOIN producto_categoria pc ON p.id = pc.producto_id
    LEFT JOIN categorias c ON pc.categoria_id = c.id\
    GROUP BY p.id
";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute();

        $catalogo = [];
        while ($result = $PDOStatement->fetch(PDO::FETCH_ASSOC)) {
            $catalogo[] = $result;
        }

        return $catalogo;
    }

    public function edit(int $idCategoria, string $nombre, string $descripcion, float $precio, string $imagen): void
    {
        $conexion = (new Conexion())->getConexion();

        // 1. Actualizar los datos principales del producto
        $query = "UPDATE productos SET 
                nombre = :nombre, 
                descripcion = :descripcion, 
                precio = :precio, 
                imagen = :imagen 
                WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'imagen' => $imagen,
            'id' => $this->id
        ]);

        // 2. Actualizar la relación con la categoría
        // Primero borramos las categorías actuales
        $PDOStatementDelete = $conexion->prepare("DELETE FROM producto_categoria WHERE producto_id = :id");
        $PDOStatementDelete->execute(['id' => $this->id]);

        // Luego insertamos la nueva categoría
        $PDOStatementInsert = $conexion->prepare("INSERT INTO producto_categoria (producto_id, categoria_id) VALUES (:producto_id, :categoria_id)");
        $PDOStatementInsert->execute([
            'producto_id' => $this->id,
            'categoria_id' => $idCategoria
        ]);

        // 3. Actualizar los atributos en el objeto
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagen = $imagen;
        $this->categorias = [['id' => $idCategoria]]; // Simplificado
    }

    public static function insert(int $idCategoria, string $nombre, string $descripcion, float $precio, string $imagen): int
    {
        $conexion = (new Conexion())->getConexion();

        // Insertar en productos
        $query = "INSERT INTO productos (nombre, descripcion, precio, imagen) 
                VALUES (:nombre, :descripcion, :precio, :imagen)";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'imagen' => $imagen
        ]);

        $idProducto = $conexion->lastInsertId();

        // Insertar en tabla pivote producto_categoria
        $query = "INSERT INTO producto_categoria (producto_id, categoria_id) 
                    VALUES (:producto_id, :categoria_id)";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([
            'producto_id' => $idProducto,
            'categoria_id' => $idCategoria
        ]);

        return $idProducto;
    }


    // marca el producto como inactivo
    public function marcarComoInactivo(): bool
    {
        $conexion = (new Conexion())->getConexion();

        $query = "UPDATE productos SET activo = 0 WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);

        return $PDOStatement->execute(['id' => $this->id]);
    }

    public function activar(): bool
    {
        $conexion = (new Conexion())->getConexion();

        $query = "UPDATE productos SET activo = 1 WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);

        return $PDOStatement->execute(['id' => $this->id]);
    }
public function todosProductosConInactivos(): array
{
    $conexion = (new Conexion())->getConexion();

    $query = "
    SELECT p.*, c.nombre AS categoria
    FROM productos p
    LEFT JOIN producto_categoria pc ON p.id = pc.producto_id
    LEFT JOIN categorias c ON pc.categoria_id = c.id
    GROUP BY p.id
    ";

    $PDOStatement = $conexion->prepare($query);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}


}