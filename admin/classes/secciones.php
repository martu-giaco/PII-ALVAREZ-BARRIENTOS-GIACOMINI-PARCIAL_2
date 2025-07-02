<?php
class Secciones
{
    private $vinculo;
    private $texto;
    private $title;
    private $inMenu;

    public function getVinculo(): string { return $this->vinculo; }
    public function getTexto(): string { return $this->texto; }
    public function getTitle(): string { return $this->title; }
    public function getInMenu(): bool { return $this->inMenu; }

    // Función privada para leer el JSON y devolver un array
    private static function cargarJSON(): array
    {
        $json = file_get_contents('../data/secciones.json');
        $datos = json_decode($json, true);
        return is_array($datos) ? $datos : [];
    }

    // Devuelve objetos Secciones con todos los datos
    public static function secciones_del_sitio(): array
    {
        $lista = [];
        $datos = self::cargarJSON();

        foreach ($datos as $sec) {
            $obj = new self();
            $obj->vinculo = $sec["vinculo"];
            $obj->texto = $sec["texto"];
            $obj->title = $sec["title"];
            $obj->inMenu = $sec["inMenu"];
            $lista[] = $obj;
        }

        return $lista;
    }

    // Devuelve array con los nombres de todas las secciones (vínculos válidos)
    public static function secciones_validas(): array
    {
        $validas = [];
        $datos = self::cargarJSON();

        foreach ($datos as $sec) {
            $validas[] = $sec["vinculo"];
        }

        return $validas;
    }

    // Devuelve array con los vínculos que van en el menú
    public static function secciones_menu(): array
    {
        $menu = [];
        $datos = self::cargarJSON();

        foreach ($datos as $sec) {
            if ($sec["inMenu"]) {
                $menu[] = $sec["vinculo"];
            }
        }

        return $menu;
    }
}
