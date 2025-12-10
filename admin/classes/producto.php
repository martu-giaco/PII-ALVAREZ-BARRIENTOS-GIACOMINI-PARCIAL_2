<?php

class Producto {
    //Propiedades privadas (atributos del producto)
    private $id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $foto;
    private $id_categoria;
    private $activo; // 1 = activo, 0 = inactivo (baja lógica)

    //Crea una instancia de Producto con todos sus datos
    public function __construct($id, $nombre, $descripcion, $precio, $foto, $id_categoria, $activo) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->foto = $foto;
        $this->id_categoria = $id_categoria;
        $this->activo = $activo;
    }

    //Devuelve el nombre del archivo de imagen (foto)
    public function getFoto() {
        return $this->foto;
    }

    //Busca un producto por su ID y devuelve un objeto Producto
    public static function get_x_id($id) {
        $db = (new Conexion())->getConexion();
        $stmt = $db->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC); // trae los datos como array asociativo

        if ($data) {
            // Retorna un nuevo objeto Producto con los datos obtenidos
            return new Producto(
                $data['id'],
                $data['nombre'],
                $data['descripcion'],
                $data['precio'],
                $data['imagen'],
                $data['id_categoria'] ?? null,
                $data['activo']
            );
        }

        // Si no se encontró, lanza una excepción
        throw new Exception("Producto no encontrado.");
    }

    //Edita un producto ya existente con nuevos datos
    public function edit($id_categoria, $nombre, $descripcion, $precio, $imagen) {
        $db = (new Conexion())->getConexion();
        $stmt = $db->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, imagen = ?, id_categoria = ? WHERE id = ?");
        $stmt->execute([$nombre, $descripcion, $precio, $imagen, $id_categoria, $this->id]);
    }

    //Reactiva el producto (activo = 1)
    public function activar() {
        $db = (new Conexion())->getConexion();
        $stmt = $db->prepare("UPDATE productos SET activo = 1 WHERE id = ?");
        $stmt->execute([$this->id]);
    }

    //Inserta un nuevo producto en la base de datos
    public static function insert($id_categoria, $nombre, $descripcion, $precio, $imagen = null) {
        $db = (new Conexion())->getConexion();

        $stmt = $db->prepare("INSERT INTO productos (id_categoria, nombre, descripcion, precio, imagen, activo) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->execute([$id_categoria, $nombre, $descripcion, $precio, $imagen]);
    }

    public function eliminarProducto(): bool
    {
        $conexion = (new Conexion())->getConexion();

        $query = "DELETE FROM productos WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);

        return $PDOStatement->execute(['id' => $this->id]);
    }
}