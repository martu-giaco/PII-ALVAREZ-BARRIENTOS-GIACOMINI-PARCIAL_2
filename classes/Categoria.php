<?php
require_once __DIR__ . '/Conexion.php';

class Categoria
{
    private $id;
    private $nombre;

    public function __construct($id = null, $nombre = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public function getIdCategoria()
    {
        return $this->id;
    }

    public function getNombreCategoria()
    {
        return $this->nombre;
    }

    public static function obtenerCategorias(): array
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT DISTINCT id, nombre FROM categorias ORDER BY nombre";
        $stmt = $conexion->prepare($query);
        $stmt->execute();

        $categoriasData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categorias = [];

        foreach ($categoriasData as $cat) {
            $categorias[] = new Categoria($cat['id'], $cat['nombre']);
        }

        return $categorias;
    }
}
