<?php
require_once("../functions/autoload.php");

// descomentar para hacer autenticacion
// Autenticacion::verify(true);

$categorias = new Categoria();
$lista = $categorias->obtenerCategorias();
?>

<h2>Administración de Categorías</h2>
<table class="table table-striped">
<thead>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Opciones</th>
</tr>
</thead>
<tbody>
<?php
foreach ($lista as $categoria) {
    ?>
    <tr>
        <td><?= htmlspecialchars($categoria->getIdCategoria()); ?></td>
        <td><?= htmlspecialchars($categoria->getNombreCategoria()); ?></td>
        <td>
            <a href="?sec=editar_categoria&id=<?= urlencode($categoria->getIdCategoria()); ?>" class="btn btn-dark text-white py-2 px-3"><i class="fas fa-edit"></i></a>
            <a href="?sec=borrar_categoria&id=<?= urlencode($categoria->getIdCategoria()); ?>" class="btn btn-danger text-white py-2 px-3"><i class="fas fa-trash-alt"></i></a>
        </td>
    </tr> 
    <?php   
}
?>
</tbody>
</table>

<a href="?sec=crear_categoria" class="btn btn-primary text-white py-2 px-3">Crear Categoria</a>
