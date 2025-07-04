<?php 
require_once("../functions/autoload.php");

// descomentar para hacer autenticacion
// Autenticacion::verify(true);

$productos = (new Producto())->todosProductosConInactivos(); // Por ejemplo, crea este método

?>

<h2>Administración de Productos</h2>
<?= Alerta::get_alertas(); ?>

<table class="table table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Categoría</th>
    <th>Nombre</th>
    <th>Descripción</th>
    <th>Precio</th>
    <th>Imagen</th>
    <th>Estado</th>
    <th>Opciones</th>
</tr>
</thead>
<tbody>

<?php foreach ($productos as $p) : ?>
    <?php
        $prod = new Producto(
            $p['id'],
            $p['nombre'],
            $p['descripcion'],
            $p['precio'],
            [['nombre' => $p['categoria']]], // para getImagen
            $p['imagen']
        );
        $img = $prod->getImagen();
        $activo = $p['activo'] ?? 1;
    ?>
    <tr>
        <td><?= htmlspecialchars($prod->getId()); ?></td>
        <td><?= htmlspecialchars($p['categoria'] ?? 'Sin categoría'); ?></td>
        <td><?= htmlspecialchars($prod->getNombre()); ?></td>
        <td><?= htmlspecialchars($prod->getDescripcion()); ?></td>
        <td>$<?= number_format($prod->getPrecio(), 2, ',', '.'); ?></td>
        <td>
            <img src="../<?= htmlspecialchars($img); ?>" alt="Imagen" width="50" style="object-fit: contain;">
        </td>
        <td>
            <?= $activo ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>'; ?>
        </td>
        <td>
            <?php if ($activo): ?>
                <a href="?sec=editar_producto&id=<?= urlencode($prod->getId()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-edit"></i></a>
                <a href="?sec=borrar_producto&id=<?= urlencode($prod->getId()); ?>" class="btn btn-danger text-white py-2 px-3"><i class="fas fa-trash-alt"></i></a>
            <?php else: ?>
                <a href="actions/reactivar_producto_acc.php?id=<?= urlencode($prod->getId()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-redo-alt"></i> Reactivar</a>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>

</tbody>
</table>

<a href="?sec=crear_producto" class="btn btn-primary text-white py-3 px-5">Crear producto nuevo</a>
