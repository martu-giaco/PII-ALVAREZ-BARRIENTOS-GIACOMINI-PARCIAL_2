<?php
class Alerta
{
    private static function ensureSessionStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Registra una alerta en el sistema, guardándola en la sesión.
     * @param string $tipo primary | secondary | success | danger | warning | info | light | dark
     * @param string $mensaje Mensaje que quiere que aparezca
     */
    public static function add_alerta(string $tipo, string $mensaje)
    {
        self::ensureSessionStarted();

        if (!isset($_SESSION['alertas'])) {
            $_SESSION['alertas'] = [];
        }

        $_SESSION['alertas'][] = [
            'tipo' => $tipo,
            'mensaje' => $mensaje
        ];
    }

    /**
     * Vacía la lista de alertas
     */
    public static function clear_alertas()
    {
        self::ensureSessionStarted();
        $_SESSION['alertas'] = [];
    }

    /**
     * Imprime una alerta individual (Bootstrap 5)
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
     * Obtiene todas las alertas almacenadas en sesión en formato HTML concatenado
     */
    public static function get_alertas()
    {
        self::ensureSessionStarted();

        if (!empty($_SESSION['alertas'])) {
            $alertasActuales = "";
            foreach ($_SESSION['alertas'] as $alerta) {
                $alertasActuales .= self::print_alerta($alerta);
            }
            self::clear_alertas();
            return $alertasActuales;
        }
        return null;
    }
}
