<?php

class Imagen
{
    public static function subirImagen($directorio, $datosArchivo)
    {
        // Solo devuelve el nuevo nombre sin mover nada
        $nombreOriginal = explode(".", $datosArchivo['name']);
        $extension = strtolower(end($nombreOriginal));
        $nombreNuevo = time() . "." . $extension;

        // NO mueve el archivo, solo simula
        return $nombreNuevo;
    }

    public static function desactivarImagen($ruta)
    {
        // No hace nada, solo simula que borró
        return true;
    }
}
