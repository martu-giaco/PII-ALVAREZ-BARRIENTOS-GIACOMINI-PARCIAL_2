<?php

class Autenticacion
{
    /**
     * Intento de login por email/usuario y contraseña.
     * Devuelve true en caso de éxito (redirige según rol) o false en caso de fallo.
     */
    public static function log_in(string $email, string $clave): bool
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    // Buscar usuario por email o usuario
    $datosUsuario = null;

    if (method_exists('Usuario', 'usuario_x_email')) {
        $datosUsuario = Usuario::usuario_x_email($email);
    }

    if (!$datosUsuario && method_exists('Usuario', 'obtenerPorUsuarioEmail')) {
        $datosUsuario = Usuario::obtenerPorUsuarioEmail($email);
    }

    if (!$datosUsuario) {
        Alerta::add_alerta('warning', "El usuario ingresado no se encontró en nuestra base de datos.");
        return false;
    }

    $hash = $datosUsuario->getClave();

    if (!password_verify($clave, $hash)) {
        Alerta::add_alerta('danger', "La clave ingresada no es correcta.");
        return false;
    }

    $datosLogin = [];
    $datosLogin['usuario'] = $datosUsuario->getUsuario();
    $datosLogin['id_usuario'] = $datosUsuario->getIdUsuario();
    $datosLogin['id_rol'] = method_exists($datosUsuario, 'getIdRol') ? $datosUsuario->getIdRol() : null;
    $datosLogin['rol'] = method_exists($datosUsuario, 'getRol') ? $datosUsuario->getRol() : null;

    $_SESSION['loggedIn'] = $datosLogin;

    Alerta::add_alerta('success', 'Sesión iniciada correctamente. Bienvenido ' . htmlspecialchars($datosLogin['usuario']) . '.');

    // Normalizar rol y redirigir usando rutas relativas dentro del proyecto
    $rolNorm = mb_strtolower(trim((string)$datosLogin['rol']));

    if ($rolNorm === 'admin') {
        // Desde admin/actions/* la ruta relativa al panel admin es: ../index.php?sec=usuarios
        header("Location: ../index.php");
        exit;
    }

    // Para clientes u otros roles: volver al index público del proyecto
    // Desde admin/actions/* la ruta relativa al front es: ../../index.php
    header("Location: ../../index.php");
    exit;
}


    /**
     * Cierra la sesión del usuario (solo limpia loggedIn)
     */
    public static function log_out()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_SESSION['loggedIn'])) {
            unset($_SESSION['loggedIn']);
        }

        // No forzar destroy de toda la sesión; solo limpiar la info de login.
        // Si se necesita destruir todo, descomentar:
        // session_destroy();

        // Redirigir al login
        header("Location: index.php?sec=login");
        exit;
    }

    /**
     * Verifica si hay sesión iniciada y, si $admin === true, que el rol sea admin.
     * Si la verificación falla, agrega alerta y redirige al login.
     */
    public static function verify($admin = true): bool
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_SESSION['loggedIn'])) {
            if ($admin) {
                if (isset($_SESSION['loggedIn']['rol']) && mb_strtolower(trim((string)$_SESSION['loggedIn']['rol'])) === "admin") {
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
