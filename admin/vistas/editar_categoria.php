<?php
// require_once("../classes/Categoria.php");
require_once("../functions/autoload.php");

// descomentar para hacer autenticacion
Autenticacion::verify(true);


$id = $_GET['id'] ?? FALSE;
$categoria = Categoria::get_x_id($id);


?>
<h2>Editar categoría</h2>
<form action="actions/editar_categoria_acc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_categoria" class="form-control" id="id_categoria" value="<?= $categoria->getIdCategoria(); ?>" >
    <div class="mb-3">
        <label for="categoria" class="form-label">Nombre de categoría</label>
        <input type="text" class="form-control" id="categoria" name="categoria" value="<?= $categoria->getNombreCategoria(); ?>">
    </div>
    <input type="submit"  class="btn btn-dark py-3 px-5" value="Editar">
    <a href="?sec=categorias" class="btn btn-danger text-white py-3 px-5">Cancelar</a>
</form>