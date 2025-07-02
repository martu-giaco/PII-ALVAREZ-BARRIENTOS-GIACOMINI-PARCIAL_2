<?php
require_once ("../classes/Categoria.php");
$categorias = new Categoria;
$lista = $categorias->todasCategorias();
?>
<h2>Agregar un nuevo producto</h2>
<form action="actions/crear_producto_acc.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de Producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre">
    </div>
    <div class="mb-3">
        <label for="presentacion" class="form-label">Presentación</label>
        <input type="text" class="form-control" id="presentacion" name="presentacion">
    </div>
    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" class="form-control" id="precio" name="precio">
    </div>
    <div class="mb-3">
        <label for="foto" class="form-label">Foto</label>
  <input class="form-control" type="file" id="foto" name="foto">
    </div>
    <div class="mb-3">
        <label for="id_categoria" class="form-label">Categoria</label>
        <select class="form-select" aria-label="Default select example" name="id_categoria">
            <option selected>Seleccione una categoria</option>
            <?php
            foreach ($lista as $categoria) {
            ?>
                <option value="<?=$categoria->getIdCategoria();?>"><?=$categoria->getCategoria();?></option>
            <?php
            }
            ?>
        </select>    
    </div>
    <input type="submit" value="Crear">
    <a href="?sec=productos" class="btn btn-danger">Cancelar</a>
</form>