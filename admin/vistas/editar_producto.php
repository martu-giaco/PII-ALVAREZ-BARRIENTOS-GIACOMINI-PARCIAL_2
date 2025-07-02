<?php
// require_once("../classes/Producto.php");
// require_once ("../classes/Categoria.php");
require_once("../functions/autoload.php");


$categorias = new Categoria;
$lista = $categorias->todasCategorias();

$id = $_GET['id'] ?? FALSE;
$producto = Producto::get_x_id($id);


?>
<h2>Editar producto</h2>
<form action="actions/editar_producto_acc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_producto" class="form-control" id="id_producto" value="<?= $producto->getIdProducto(); ?>" >

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de Producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $producto->getNombre(); ?>">
    </div>
    <div class="mb-3">
        <label for="presentacion" class="form-label">Presentación</label>
        <input type="text" class="form-control" id="presentacion" name="presentacion" value="<?= $producto->getPresentacion(); ?>">
    </div>
    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="text" class="form-control" id="precio" name="precio"  value="<?= $producto->getPrecio(); ?>">
    </div>
    <div class="mb-3">
        <label for="fotoActual" class="form-label">Foto actual</label>
        <img src="../img/productos/<?= $producto->getFoto();?>" alt="Imagen actual" width="100">
        <input class="form-control" type="hidden" id="imagen_og" name="imagen_og" value="<?= $producto->getFoto();?>">
    </div>
    <div class="mb-3">
        <label for="foto" class="form-label">Foto</label>
        <input class="form-control" type="file" id="foto" name="foto" >
    </div>
    <div class="mb-3">
        <label for="id_categoria" class="form-label">Categoria</label>
        <select class="form-select" aria-label="Default select example" name="id_categoria">
            <option selected>Seleccione una categoria</option>
            <?php
            foreach ($lista as $categoria) {
            ?>
                <option value="<?= $categoria->getIdCategoria();?>" <?= $categoria->getIdCategoria()==$producto->getIdCategoria() ? "selected": ""; ?>><?=$categoria->getCategoria();?></option>
            <?php
            }
            ?>
        </select>    
    </div>
    <input type="submit"  class="btn btn-warning" value="Editar">
    <a href="?sec=productos" class="btn btn-danger">Cancelar</a>
</form>