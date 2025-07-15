<?php
require_once __DIR__ . '/../../functions/autoload.php';

// descomentar para hacer autenticacion
Autenticacion::verify(true);


$categorias = (new Categoria())->obtenerCategoriasConInactivas(); // Método que debes agregar

?>

<h2 class="mb-3">Categorías</h2>
<?= Alerta::get_alertas(); ?>

<table class="table table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Imagen</th>
    <th>Estado</th>
    <th>Opciones</th>
</tr>
</thead>
<tbody>
<?php
foreach ($categorias as $categoria) {
    $activo = $categoria->activo ?? 1;
    ?>
    <tr>
        <td><?= htmlspecialchars($categoria->getIdCategoria()); ?></td>
        <td><?= htmlspecialchars($categoria->getNombreCategoria()); ?></td>
        <td>
            <?= $activo ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>'; ?>
        </td>
        <td><img src="../assets/imagenes/categorias-fotitos/<?= htmlspecialchars($categoria->getImagenCategoria()); ?>" alt="Imagen" width="50" style="object-fit: contain;"></td>
        <td>
            <?php if ($activo): ?>
                <a href="?sec=editar_categoria&id=<?= urlencode($categoria->getIdCategoria()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-edit"></i></a>
                <a href="?sec=borrar_categoria&id=<?= urlencode($categoria->getIdCategoria()); ?>" class="btn btn-danger text-white py-2 px-3"><i class="fas fa-trash-alt"></i></a>
            <?php else: ?>
                <a href="actions/reactivar_categoria_acc.php?id=<?= urlencode($categoria->getIdCategoria()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-redo-alt"></i> Reactivar</a>
            <?php endif; ?>
        </td>
    </tr> 
    <?php   
}
?>
</tbody>
</table>

<a href="?sec=crear_categoria" class="btn btn-primary text-white py-3 px-5">Crear categoria nueva</a>
