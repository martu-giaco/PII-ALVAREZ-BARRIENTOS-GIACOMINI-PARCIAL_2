<?php
require_once __DIR__ . '/../../functions/autoload.php';

// descomentar para hacer autenticacion
Autenticacion::verify(true);

$usuario = new Usuario();
$lista = $usuario->obtenerUsuarios();

$id = $_GET['id'] ?? FALSE;
$usuario = Usuario::get_x_id($id);

if (!$usuario) {
    die("Usuario no encontrado.");
}
?>

<h2>Editar usuario</h2>
<form action="actions/editar_usuario_acc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_usuario" class="form-control" id="id_usuario" value="<?= $usuario->getIdusuario(); ?>" >

    <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" id="usuario" name="usuario" value="<?= $usuario->getUsuario(); ?>">
    </div>
    
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $usuario->getEmail(); ?>">
    </div>
    <div class="mb-3">
        <label for="clave" class="form-label">Clave</label>
        <input type="password" class="form-control" id="clave" name="clave" value="<?= $usuario->getClave(); ?>">
    </div>

<!--     ACÁ IRÍA UN SELECT PARA LOS ROLES, no estoy muy segura como están conectados pq viste q están en una tabla aparte, tengo miedo de tocar y romper algo del login así q después hagamoslo juntas quizas? esto está copypasteado del select de categoria de editar_producto
    <div class="mb-3">
        <label for="id_categoria" class="form-label">Roles</label>
        <select class="form-select" name="id_categoria">
            <option disabled>Seleccione un rol para este usuario</option>
            < ?php foreach ($lista as $categoria): ?>
                <option value="< ?= $categoria->getIdCategoria(); ?>"
                    < ?= ($usuario->getRol()[0]['id'] ?? null) == $categoria->getIdCategoria() ? 'selected' : '' ?>>
                    < ?= htmlspecialchars($categoria->getNombreCategoria()); ?>
                </option>
            < ?php endforeach; ?>
        </select>
    </div> -->
    

    <input type="submit"  class="btn btn-dark py-3 px-5" value="Editar">
    <a href="?sec=usuarios" class="btn btn-danger text-white py-3 px-5">Cancelar</a>
</form>