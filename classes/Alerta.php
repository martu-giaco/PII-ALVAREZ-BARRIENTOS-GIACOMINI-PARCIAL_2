<?php
class Alerta
{
    /**
     * Agrega una alerta a la sesión.
     * @param string $tipo primary | secondary | success | danger | warning | info | light | dark
     * @param string $mensaje
     */
    public static function add_alerta(string $tipo, string $mensaje)
    {
        if (!isset($_SESSION['alertas'])) {
            $_SESSION['alertas'] = [];
        }

        $_SESSION['alertas'][] = [
            'tipo' => $tipo,
            'mensaje' => $mensaje
        ];
    }

    /**
     * Vacía todas las alertas de la sesión.
     */
    public static function clear_alertas()
    {
        $_SESSION['alertas'] = [];
    }

    /**
     * Imprime una alerta individual con Bootstrap 5.
     * @param array $alerta
     * @return string HTML generado
     */
    public static function print_alerta($alerta): string
    {
        $html = "<div class='alert alert-{$alerta['tipo']} alert-dismissible fade show' role='alert'>";
        $html .= htmlspecialchars($alerta['mensaje'], ENT_QUOTES | ENT_HTML5);
        $html .= "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Cerrar'></button>";
        $html .= "</div>";
        return $html;
    }

    /**
     * Devuelve todas las alertas actuales y las elimina de la sesión.
     * @return string|null
     */
    public static function get_alertas(): ?string
    {
        if (!empty($_SESSION['alertas'])) {
            $htmlAlertas = '';
            foreach ($_SESSION['alertas'] as $alerta) {
                $htmlAlertas .= self::print_alerta($alerta);
            }
            self::clear_alertas(); // Borra alertas luego de mostrarlas
            return $htmlAlertas;
        }
        return null;
    }
}
