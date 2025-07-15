<?php
require_once __DIR__ . '/../../functions/autoload.php';

// descomentar para hacer autenticacion
Autenticacion::verify(true);
$categorias = new Categoria();
$lista = $categorias->obtenerCategorias();
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
        <input type="number" step="0.01" class="form-control" id="precio" name="precio">
    </div>

    <div class="mb-3">
        <label for="foto" class="form-label">Foto</label>
        <input class="form-control" type="file" id="foto" name="foto">
    </div>

    <div class="mb-3">
        <label for="id_categoria" class="form-label">Categoría</label>
        <select class="form-select" name="id_categoria" id="id_categoria">
            <option disabled selected>Seleccione una categoría</option>
            <?php foreach ($lista as $categoria): ?>
                <option value="<?= $categoria->getIdCategoria(); ?>">
                    <?= $categoria->getNombreCategoria(); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <input type="submit" value="Crear" class="btn btn-primary py-3 px-5">
    <a href="?sec=productos" class="btn btn-danger text-white py-3 px-5">Cancelar</a>
</form>
