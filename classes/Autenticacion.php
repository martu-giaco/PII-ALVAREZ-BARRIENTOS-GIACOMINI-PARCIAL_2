<?php
class Autenticacion
{
    public static function log_in(string $usuario, string $password): mixed
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $datosUsuario = Usuario::usuario_x_username($usuario);

        if ($datosUsuario) {
            if (password_verify($password, $datosUsuario->getClave())) {
                $datosLogin['usuario'] = $datosUsuario->getUsuario();
                $datosLogin['nombre'] = method_exists($datosUsuario, 'getNombre') ? $datosUsuario->getNombre() : '';
                $datosLogin['id_usuario'] = $datosUsuario->getIdUsuario();
                $datosLogin['id_rol'] = method_exists($datosUsuario, 'getIdRol') ? $datosUsuario->getIdRol() : null;
                $datosLogin['rol'] = method_exists($datosUsuario, 'getRol') ? $datosUsuario->getRol() : null;

                $_SESSION['loggedIn'] = $datosLogin;

                return $datosLogin['rol'];
            } else {
                Alerta::add_alerta('danger', "La clave ingresada no es correcta.");
                return false;
            }
        } else {
            Alerta::add_alerta("warning", "El usuario ingresado no se encontró en nuestra base de datos.");
            return null;
        }
    }

    public static function log_out()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['loggedIn'])) {
            unset($_SESSION['loggedIn']);
        }
    }

    public static function verify($admin = true): bool
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_SESSION['loggedIn'])) {
            if ($admin) {
                if (isset($_SESSION['loggedIn']['rol']) && $_SESSION['loggedIn']['rol'] === "admin") {
                    return true;
                } else {
                    Alerta::add_alerta("warning", "No tiene permisos para visualizar la página.");
                    header("Location: index.php?sec=login");
                    exit;
                }
            } else {
                return true;
            }
        } else {
            Alerta::add_alerta("danger", "Iniciar sesión para continuar.");
            header("Location: index.php?sec=login");
            exit;
        }
    }
}
?>
