<?php
class Autenticacion
{
    public static function log_in(string $usuario, string $password): bool
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $datosUsuario = Usuario::getId();
        if ($datosUsuario) {
            $hash = $datosUsuario->getClave();
            $valid = false;
            if (password_get_info($hash)['algo'] !== 0) {
                $valid = password_verify($password, $hash);
            } else {
                $valid = ($password === $hash);
            }
            if ($valid) {
                $_SESSION['loggedIn'] = [
                    'usuario' => $datosUsuario->getUsuario(),
                    'email' => $datosUsuario->getEmail(),
                    'id_usuario' => $datosUsuario->getIdUsuario(),
                    'rol' => $datosUsuario->getRol()
                ];
                return true;
            } else {
                Alerta::add_alerta('danger', "La clave ingresada no es correcta.");
                return false;
            }
        } else {
            Alerta::add_alerta("warning", "El usuario ingresado no se encontró en nuestra base de datos.");
            return false;
        }
    }

    public static function log_out()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (isset($_SESSION['loggedIn'])) {
            unset($_SESSION['loggedIn']);
            session_destroy();
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
            Alerta::add_alerta("danger", "Debe iniciar sesión para continuar.");
            header("Location: index.php?sec=login");
            exit;
        }
    }
}
?>
