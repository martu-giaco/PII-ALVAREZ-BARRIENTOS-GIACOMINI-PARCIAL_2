<?php
class Autenticacion
{
    public static function log_in(string $usuario, string $password): mixed
    // public static function log_in(string $usuario, string $password)
    {
        $datosUsuario = Usuario::usuario_x_username($usuario);

        if($datosUsuario){
            if(password_verify($password, $datosUsuario->getClave())){
                // if($password == $datosUsuario->getClave()){
                $datosLogin['usuario'] = $datosUsuario->getUsuario();
                $datosLogin['nombre'] = $datosUsuario->getNombre();
                $datosLogin['id_usuario'] = $datosUsuario->getIdUsuario();
                $datosLogin['id_nivel'] = $datosUsuario->getIdNivel();
                $datosLogin['nivel'] = $datosUsuario->getNivel();
                $_SESSION['loggedIn'] = $datosLogin;
                    echo "<pre>";
                    print_r($datosLogin);
                    echo "</pre>";
                    echo "<pre>";
                    print_r($_SESSION);
                    echo "</pre>";
                return $datosLogin['nivel'];
            }else{
                Alerta::add_alerta('danger', "La clave ingresada no es correcta.");
                // echo "<p>Contraseña incorrecta</p>";
                return FALSE;
            }
        }else{
            Alerta::add_alerta("warning", "El usuario ingresado no se encontró en nuestra base de datos.");
            // echo "<p>Usuario incorrecto</p>";
            return NULL;
        }
    }

    public static function log_out()
    {
        if(isset($_SESSION['loggedIn'])){
            unset($_SESSION['loggedIn']);
        }
    }

    public static function verify($admin = TRUE): bool
    {
        if(isset($_SESSION['loggedIn'])){
            if($admin){
                // if($_SESSION['loggedIn']['id_nivel'] == 1){
                if($_SESSION['loggedIn']['nivel'] == "admin"){
                    return TRUE;
                }else{
                    Alerta::add_alerta("warning", "No tiene permisos para visualizar la página.");
                    header("location: index.php?sec=login");
                }
            }else{
                return TRUE;
            }
        }else{
            Alerta::add_alerta("danger", "Debe iniciar sesión para continuar.");

            header("location: index.php?sec=login");
        }
    }
}
?>