<?php
require_once __DIR__ . '/../../functions/autoload.php';
require_once __DIR__ . '/../../classes/Compra.php';
require_once __DIR__ . '/../../classes/Alerta.php';

Autenticacion::verify(true); // Solo admin

// Obtener todas las compras
$compras = Compra::obtenerTodas();
?>

<h2 class="mb-3">Compras de los usuarios</h2>
<?= Alerta::get_alertas(); ?>

<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>ID Compra</th>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Productos</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($compras as $c):
            // Cargar productos de la compra
            $c->cargarDetalles();
            $productos = $c->getDetalles();
        ?>
            <tr>
                <td><?= $c->getId(); ?></td>
                <td><?= htmlspecialchars($c->getUsuario()); ?></td>
                <td><?= htmlspecialchars($c->getNombreCliente()); ?></td>
                <td><?= htmlspecialchars($c->getEmail()); ?></td>
                <td>$<?= number_format($c->getTotal(), 2, ',', '.'); ?></td>
                <td><?= date('d/m/Y H:i', strtotime($c->getFecha())); ?></td>
                <td>
                    <?= $c->getEstado() === 'completado'
                        ? '<span class="badge bg-success">Completado</span>'
                        : '<span class="badge bg-warning text-dark">Pendiente</span>'; ?>
                </td>
                <td>
                    <?php if (!empty($productos)): ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($productos as $prod): ?>
                                <li class="d-flex align-items-center mb-1">
                                    <img src="../<?= $c->getImagenProducto($prod); ?>" 
     alt="<?= htmlspecialchars($prod['nombre_producto']); ?>" 
     style="height:40px; width:auto; margin-right:10px;">

<span><?= htmlspecialchars($prod['nombre_producto']); ?> x <?= $prod['cantidad']; ?></span>

                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <span>No hay productos</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="?sec=editar_compra&id=<?= $c->getId(); ?>" class="btn btn-primary btn-md text-white">Editar</a>

                    <a href="?sec=eliminar_compra&id=<?= $c->getId(); ?>"
                        class="btn btn-danger btn-md text-white">
                        Eliminar
                    </a>


                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>