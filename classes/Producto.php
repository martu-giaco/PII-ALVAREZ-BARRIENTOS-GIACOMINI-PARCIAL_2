<?php
class Producto
{
    private $id_producto;
    private $id_marca;
    private $marca;
    private $nombre;
    private $presentacion;
    private $precio;
    private $foto;

    public function getIdProducto()
    {
        return $this->id_producto;
    }

    public function getIdMarca()
    {
        return $this->id_marca;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getPresentacion()
    {
        return $this->presentacion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Devuelve una lista de todos los productos, generando la imagen automáticamente si no existe
     */
    public function todosProductos(): array
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT p.id_producto, p.id_marca, m.marca, p.nombre, p.presentacion, p.precio, p.foto
                  FROM productos AS p
                  JOIN marcas AS m ON p.id_marca = m.id_marca";

        $stmt = $conexion->prepare($query);
        $stmt->execute();

        $productos = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $producto = new Producto();
            $producto->id_producto = $fila['id_producto'];
            $producto->id_marca = $fila['id_marca'];
            $producto->marca = $fila['marca'];
            $producto->nombre = $fila['nombre'];
            $producto->presentacion = $fila['presentacion'];
            $producto->precio = (float)$fila['precio'];

            // Foto: si está vacía en la DB, se genera automáticamente
            if (!empty($fila['foto'])) {
                $producto->foto = $fila['foto'];
            } else {
                $nombreNormalizado = strtolower($fila['nombre']);
                $nombreNormalizado = preg_replace('/[^a-z0-9]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $nombreNormalizado));
                $producto->foto = $nombreNormalizado . '.jpg';
            }

            $productos[] = $producto;
        }

        return $productos;
    }

    /**
     * Inserta un nuevo producto
     */
    public static function insert(int $id_marca, string $nombre, string $presentacion, float $precio, string $foto)
    {
        $conexion = (new Conexion())->getConexion();

        $query = "INSERT INTO productos (id_marca, nombre, presentacion, precio, foto)
                  VALUES (:id_marca, :nombre, :presentacion, :precio, :foto)";

        $stmt = $conexion->prepare($query);
        $stmt->execute([
            'id_marca' => $id_marca,
            'nombre' => $nombre,
            'presentacion' => $presentacion,
            'precio' => $precio,
            'foto' => $foto
        ]);
    }

    /**
     * Devuelve un producto por su ID
     */
    public static function get_x_id(int $id): ?Producto
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT p.id_producto, p.id_marca, m.marca, p.nombre, p.presentacion, p.precio, p.foto
                  FROM productos AS p
                  JOIN marcas AS m ON p.id_marca = m.id_marca
                  WHERE p.id_producto = :id";

        $stmt = $conexion->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt->execute(['id' => $id]);

        $producto = $stmt->fetch();

        return $producto ?: null;
    }

    /**
     * Edita los datos del producto actual
     */
    public function edit($id_marca, $nombre, $presentacion, $precio, $foto)
    {
        $conexion = (new Conexion())->getConexion();

        $query = "UPDATE productos 
                  SET id_marca = :id_marca, nombre = :nombre, presentacion = :presentacion, precio = :precio, foto = :foto 
                  WHERE id_producto = :id";

        $stmt = $conexion->prepare($query);
        $stmt->execute([
            'id_marca' => $id_marca,
            'nombre' => $nombre,
            'presentacion' => $presentacion,
            'precio' => $precio,
            'foto' => $foto,
            'id' => $this->id_producto
        ]);
    }

    /**
     * Borra el producto actual de la base de datos
     */
    public function delete()
    {
        $conexion = (new Conexion())->getConexion();

        $query = "DELETE FROM productos WHERE id_producto = :id";

        $stmt = $conexion->prepare($query);
        $stmt->execute(['id' => $this->id_producto]);
    }
}
?>
