<?php
require_once __DIR__ . '/Conexion.php';

class Categoria
{
    private $id;
    private $nombre;
    private $imagen_categoria;

    public function __construct($id = null, $nombre = null, $imagen_categoria = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->imagen_categoria = $imagen_categoria;
    }

    public function getIdCategoria()
    {
        return $this->id;
    }

    public function getNombreCategoria()
    {
        return $this->nombre;
    }

    public function getImagenCategoria()
    {
        return $this->imagen_categoria;
    }

    public static function obtenerCategorias(): array
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT id, nombre, imagen_categoria FROM categorias WHERE activo = 1 ORDER BY nombre";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute();

        $categoriasData = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        $categorias = [];

        foreach ($categoriasData as $cat) {
            $categorias[] = new Categoria($cat['id'], $cat['nombre'], $cat['imagen_categoria']);
        }

        return $categorias;
    }

    public static function get_x_id(int $id): ?Categoria
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT id, nombre, imagen_categoria FROM categorias WHERE id = :id LIMIT 1";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(['id' => $id]);

        $cat = $PDOStatement->fetch(PDO::FETCH_ASSOC);

        if (!$cat) {
            return null; // No se encontró
        }

        return new Categoria($cat['id'], $cat['nombre'], $cat['imagen_categoria']);
    }


    public static function edit(int $id, string $nombre, ?string $imagen_categoria = null): void
    {
        $conexion = (new Conexion())->getConexion();

        if ($imagen_categoria !== null && $imagen_categoria !== '') {
            $query = "UPDATE categorias SET nombre = :nombre, imagen_categoria = :imagen_categoria WHERE id = :id";
            $PDOStatement = $conexion->prepare($query);
            $PDOStatement->execute([
                'id' => $id,
                'nombre' => $nombre,
                'imagen_categoria' => $imagen_categoria,
            ]);
        } else {
            $query = "UPDATE categorias SET nombre = :nombre WHERE id = :id";
            $PDOStatement = $conexion->prepare($query);
            $PDOStatement->execute([
                'id' => $id,
                'nombre' => $nombre,
            ]);
        }
    }


    public static function insert(string $nombre, ?string $imagen_categoria = null): void
    {
        $conexion = (new Conexion())->getConexion();

        $query = "INSERT INTO categorias (nombre, imagen_categoria) VALUES (:nombre, :imagen_categoria)";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(['nombre' => $nombre, 'imagen_categoria' => $imagen_categoria]);
    }


    public function eliminarCategoria(): bool
    {
        $conexion = (new Conexion())->getConexion();

        $query = "DELETE FROM categorias WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);

        return $PDOStatement->execute(['id' => $this->id]);
    }

    public function marcarCategoriaComoInactiva(): bool
    {
        $conexion = (new Conexion())->getConexion();

        $query = "UPDATE categorias SET activo = 0 WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);

        return $PDOStatement->execute(['id' => $this->id]);
    }

    public function activar(): bool
    {
        $conexion = (new Conexion())->getConexion();

        $query = "UPDATE categorias SET activo = 1 WHERE id = :id";
        $PDOStatement = $conexion->prepare($query);

        return $PDOStatement->execute(['id' => $this->id]);
    }
    public function obtenerCategoriasConInactivas(): array
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT * FROM categorias ORDER BY id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute();

        $categoriasData = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        $categorias = [];

        foreach ($categoriasData as $cat) {
            $categoria = new Categoria($cat['id'], $cat['nombre'], $cat['imagen_categoria']);
            $categoria->activo = $cat['activo'] ?? 1;  // agregar propiedad dinámica para estado
            $categorias[] = $categoria;
        }

        return $categorias;
    }


}