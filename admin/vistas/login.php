<?php
// unset($_SESSION['loggedIn']);
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
//para obtener el dato hasheado que almacenaremos en nuestra base de datos, podemos utilizar password_hash(), que siempre serán 64 caracteres, pero será un hash diferente cada vez que ejecutemos la función
// $passwordHash = password_hash("123", PASSWORD_DEFAULT);
// echo "<p>" . $passwordHash . "</p>";


//password_verify() asegurará que el String provisto como primer parámetro pueda haber sido la versión original del hash proviso como segundo parámetro y devolverá TRUE o FALSE dependiendo del resultado.
// $passwordVerify = password_verify("123", $passwordHash);
// echo "<pre>$passwordVerify</pre>";

//sesiones: La sesión tiene forma de un array asociativo al que podremos acceder mediante la superglobal $_SESSION
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

$_SESSION["pepe"]= "Hola";

unset($_SESSION["pepe"]);
//Necesitaremos iniciar la sesión para que exista dicha superglobal

// session_start();

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

// $_SESSION['nombreUsuario'] = "Laura";
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

//Para eliminar variables de la sesión, podemos utilizar la función unset() pasándole como parámetro la variable a eliminar.
// unset($_SESSION['nombreUsuario']);
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
?>
<section class="container">
    <form action="actions/login.php" method="post" enctype="multipart/form-data">
        <h1 class="h3 mb-3 fw-normal">Iniciar Sesión</h1>
        <div>
            <?php echo Alerta::get_alertas();  ?>
        </div>
        <div class="form-floating m-3">
            <input type="text" class="form-control" id="floatingInput" placeholder="Usuario" name="usuario">
            <label for="floatingInput">Nombre de usuario</label>
        </div>
        <div class="form-floating m-3">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Clave" name="clave">
            <label for="floatingPassword">Clave</label>
        </div>
        <input type="submit" value="Login" class="btn btn-primary w-100 py-2 m-3">
    </form>
</section>