<?php 

require_once("../functions/autoload.php");

Autenticacion::verify(true);

$producto = new Producto;

$lista = $producto->todosProductos();
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
    <th>Likes</th>
    <th>Opciones</th>
</tr>
</thead>
<tbody>

<?php foreach ($lista as $producto) : ?>
    <tr>
        <td><?= htmlspecialchars($producto['id']); ?></td>

        <!-- Aquí asumimos que $producto['categoria'] es el nombre de la categoría -->
        <td><?= htmlspecialchars($producto['categoria'] ?? 'Sin categoría'); ?></td>

        <td><?= htmlspecialchars($producto['nombre']); ?></td>

        <!-- Cambié Presentación por Descripción, porque en tu tabla no tienes presentación -->
        <td><?= htmlspecialchars($producto['descripcion']); ?></td>

        <td>$<?= number_format($producto['precio'], 2, ',', '.'); ?></td>

        <!-- Imagen: asegúrate que exista la clave 'imagen' en $producto -->
        <td>
            <?php if (!empty($producto['imagen'])) : ?>
                <img src="../img/productos/<?= htmlspecialchars($producto['imagen']); ?>" alt="Imagen producto" width="100">
            <?php else: ?>
                <span>No disponible</span>
            <?php endif; ?>
        </td>

        <td>
            <?php
            // Si tu clase Producto no tiene método getLikeNombreUsuario(), esta parte debes ajustar.
            // Aquí pongo ejemplo vacío:
            echo "N/A"; 
            ?>
        </td>

        <td>
            <a href="?sec=editar_producto&id=<?= urlencode($producto['id']); ?>" class="btn btn-warning">Editar</a>
            <a href="?sec=borrar_producto&id=<?= urlencode($producto['id']); ?>" class="btn btn-danger">Borrar</a>
        </td>
    </tr>
<?php endforeach; ?>

</tbody>
</table>

<a href="?sec=crear_producto" class="btn btn-primary">Crear Producto</a>