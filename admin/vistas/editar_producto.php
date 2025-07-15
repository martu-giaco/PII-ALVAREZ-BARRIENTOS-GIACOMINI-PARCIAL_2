<?php
require_once __DIR__ . '/../../functions/autoload.php';

// descomentar para hacer autenticacion
Autenticacion::verify(true);

$categorias = new Categoria();
$lista = $categorias->obtenerCategorias();

$id = $_GET['id'] ?? false;
$producto = Producto::get_x_id(intval($id));

if (!$producto) {
    die("Producto no encontrado.");
}
?>

<h2>Editar producto</h2>

<form action="actions/editar_producto_acc.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_producto" value="<?= $producto->getIdProducto(); ?>">

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de Producto</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($producto->getNombre()); ?>">
    </div>

    <div class="mb-3">
        <label for="presentacion" class="form-label">Descripción</label>
        <input type="text" class="form-control" id="presentacion" name="presentacion" value="<?= htmlspecialchars($producto->getDescripcion()); ?>">
    </div>

    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?= htmlspecialchars($producto->getPrecio()); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Foto actual</label><br>
        <img src="../assets/imagenes/prods/<?= htmlspecialchars($producto->getImagen()); ?>" alt="Imagen actual" width="250">
        <input type="hidden" name="imagen_og" value="<?= htmlspecialchars($producto->getImagen()); ?>">
    </div>

    <div class="mb-3">
        <label for="foto" class="form-label">Nueva Foto (opcional)</label>
        <input class="form-control" type="file" id="foto" name="foto">
    </div>

    <div class="mb-3">
        <label for="id_categoria" class="form-label">Categoría</label>
        <select class="form-select" name="id_categoria">
            <option disabled>Seleccione una categoría</option>
            <?php foreach ($lista as $categoria): ?>
                <option value="<?= $categoria->getIdCategoria(); ?>"
                    <?= ($producto->getCategorias()[0]['id'] ?? null) == $categoria->getIdCategoria() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categoria->getNombreCategoria()); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <input type="submit" class="btn btn-dark py-3 px-5" value="Editar">
    <a href="?sec=productos" class="btn btn-danger py-3 px-5 text-white">Cancelar</a>
</form>
