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

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public static function obtenerCategorias(): array
    {
        $conexion = (new Conexion())->getConexion();

        $query = "SELECT DISTINCT id, nombre FROM categorias ORDER BY nombre";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute();

        $categoriasData = $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
        $categorias = [];

        foreach ($categoriasData as $cat) {
            $categorias[] = new Categoria($cat['id'], $cat['nombre']);
        }

        return $categorias;
    }
}
