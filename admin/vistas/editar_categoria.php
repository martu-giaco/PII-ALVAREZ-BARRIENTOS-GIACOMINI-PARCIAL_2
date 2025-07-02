<?php
// require_once("../classes/Categoria.php");
require_once("../functions/autoload.php");


$id = $_GET['id'] ?? FALSE;
$categoria = Categoria::get_x_id($id);


?>
<h2>Editar categoría</h2>
<form action="actions/editar_categoria_acc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_categoria" class="form-control" id="id_categoria" value="<?= $categoria->getIdCategoria(); ?>" >
    <div class="mb-3">
        <label for="categoria" class="form-label">Nombre de categoría</label>
        <input type="text" class="form-control" id="categoria" name="categoria" value="<?= $categoria->getCategoria(); ?>">
    </div>
    <input type="submit"  class="btn btn-warning" value="Editar">
    <a href="?sec=categorias" class="btn btn-danger">Cancelar</a>
</form>